<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\FormCctv\MasterSigner;
use App\Models\FormBastik\FormBastik;
use App\Models\FormBastik\NomorSuratCounter;
use App\Models\FormBastik\ApprovalHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormBastikTest extends TestCase
{
    use RefreshDatabase;

    protected $petugas;
    protected $pimpinan;
    protected $pimpinan2;
    protected $admin;
    protected $signer;

    protected function setUp(): void
    {
        parent::setUp();

        // Create mock signer
        $this->signer = MasterSigner::create([
            'nama' => 'Bambang Sutrisno',
            'nipp' => '00.5544.10',
            'jabatan' => 'Manager TI',
        ]);

        // Create mock users
        $this->petugas = User::create([
            'name' => 'Rina Amelia',
            'email' => 'rina@kai.id',
            'password' => bcrypt('password'),
            'role' => 'petugas',
            'nip_kwt' => '00.1234.56',
            'unit_kerja' => 'TI',
        ]);

        $this->pimpinan = User::create([
            'name' => 'Bambang Sutrisno',
            'email' => 'bambang@kai.id',
            'password' => bcrypt('password'),
            'role' => 'pimpinan',
            'nip_kwt' => '00.5544.10',
            'unit_kerja' => 'TI',
        ]);

        $this->pimpinan2 = User::create([
            'name' => 'Ahmad Pimpinan',
            'email' => 'ahmad@kai.id',
            'password' => bcrypt('password'),
            'role' => 'pimpinan',
            'nip_kwt' => '00.9999.88',
            'unit_kerja' => 'TI',
        ]);

        $this->admin = User::create([
            'name' => 'Admin Sistem',
            'email' => 'admin@kai.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'nip_kwt' => '00.0000.01',
            'unit_kerja' => 'TI',
        ]);
    }

    /**
     * Scenario 1: Test draft creation.
     */
    public function test_can_create_bastik_draft()
    {
        $this->actingAs($this->petugas);

        $payload = [
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'Kantor Pusat Bandung',
            'action' => 'draft',
            'items' => [
                [
                    'no_tiket' => 'INC00123',
                    'detail_tiket' => 'Test Detail 1',
                    'user_pemohon' => 'Andi',
                    'nipp' => '111',
                    'unit' => 'Unit A',
                ]
            ]
        ];

        $response = $this->post(route('form-bastik.store'), $payload);

        $response->assertRedirect();
        $this->assertDatabaseHas('form_bastiks', [
            'status' => 'draft',
            'nomor_surat' => null,
            'kota' => 'Bandung',
        ]);
    }

    /**
     * Scenario 2: Test submitting document for approval.
     */
    public function test_petugas_can_submit_bastik_for_approval()
    {
        $this->actingAs($this->petugas);

        $payload = [
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'Kantor Pusat Bandung',
            'action' => 'generate', // submit for approval
            'items' => [
                [
                    'no_tiket' => 'INC00123',
                    'detail_tiket' => 'Test Detail 1',
                    'user_pemohon' => 'Andi',
                    'nipp' => '111',
                    'unit' => 'Unit A',
                ]
            ]
        ];

        $response = $this->post(route('form-bastik.store'), $payload);
        $response->assertRedirect();

        $this->assertDatabaseHas('form_bastiks', [
            'status' => 'submitted',
            'nomor_surat' => null, // Nomor surat should NOT be generated on submit
        ]);

        $this->assertDatabaseHas('approval_histories', [
            'action' => 'SUBMIT',
            'from_status' => 'draft',
            'to_status' => 'submitted',
        ]);
    }

    /**
     * Scenario 3: Test Pimpinan approving submitted document.
     */
    public function test_pimpinan_can_approve_submitted_bastik()
    {
        $bastik = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'submitted',
            'qr_token' => 'token-test-approve-123',
        ]);

        $this->actingAs($this->pimpinan);

        $response = $this->patch(route('form-bastik.approve', $bastik->id));
        $response->assertRedirect();

        $bastik->refresh();
        $this->assertEquals('signed', $bastik->status);
        $this->assertEquals('001/BA-INC/TI/VII/2026', $bastik->nomor_surat);
        $this->assertEquals($this->pimpinan->id, $bastik->approved_by);
        $this->assertNotNull($bastik->approved_at);

        $this->assertDatabaseHas('approval_histories', [
            'form_bastik_id' => $bastik->id,
            'user_id' => $this->pimpinan->id,
            'action' => 'APPROVE',
            'from_status' => 'submitted',
            'to_status' => 'signed',
        ]);
    }

    /**
     * Scenario 4: Test Pimpinan rejecting submitted document with mandatory note.
     */
    public function test_pimpinan_can_reject_submitted_bastik_with_reason()
    {
        $bastik = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'submitted',
            'qr_token' => 'token-test-reject-123',
        ]);

        $this->actingAs($this->pimpinan);

        $response = $this->patch(route('form-bastik.reject', $bastik->id), [
            'rejection_note' => 'Nomor tiket belum sesuai dengan lampiran.',
        ]);

        $response->assertRedirect();

        $bastik->refresh();
        $this->assertEquals('rejected', $bastik->status);
        $this->assertEquals('Nomor tiket belum sesuai dengan lampiran.', $bastik->rejection_note);
        $this->assertNull($bastik->nomor_surat); // Nomor surat should NOT be issued on reject

        $this->assertDatabaseHas('approval_histories', [
            'form_bastik_id' => $bastik->id,
            'user_id' => $this->pimpinan->id,
            'action' => 'REJECT',
            'note' => 'Nomor tiket belum sesuai dengan lampiran.',
        ]);
    }

    /**
     * Scenario 5: Test unauthorized user (petugas) cannot approve document.
     */
    public function test_unauthorized_user_cannot_approve_bastik()
    {
        $bastik = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'submitted',
            'qr_token' => 'token-test-unauth-123',
        ]);

        $this->actingAs($this->petugas);

        $response = $this->patch(route('form-bastik.approve', $bastik->id));
        $response->assertStatus(403);

        $this->assertEquals('submitted', $bastik->fresh()->status);
    }

    /**
     * Scenario 6: Test unauthorized user (petugas) cannot reject document.
     */
    public function test_unauthorized_user_cannot_reject_bastik()
    {
        $bastik = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'submitted',
            'qr_token' => 'token-test-unauth-reject',
        ]);

        $this->actingAs($this->petugas);

        $response = $this->patch(route('form-bastik.reject', $bastik->id), [
            'rejection_note' => 'Unauthorized reject attempt',
        ]);

        $response->assertStatus(403);
        $this->assertEquals('submitted', $bastik->fresh()->status);
    }

    /**
     * Scenario 7: Test self-approval prevention (creator cannot approve their own document).
     */
    public function test_creator_cannot_approve_own_document()
    {
        // Pimpinan created document as petugas
        $bastik = FormBastik::create([
            'petugas_id' => $this->pimpinan->id,
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'submitted',
            'qr_token' => 'token-test-self-approval',
        ]);

        $this->actingAs($this->pimpinan);

        $response = $this->patch(route('form-bastik.approve', $bastik->id));
        $response->assertRedirect();
        $response->assertSessionHas('error');

        // Document status remains unchanged
        $this->assertEquals('submitted', $bastik->fresh()->status);
    }

    /**
     * Scenario 8: Test double approval is prevented.
     */
    public function test_double_approval_is_prevented()
    {
        $bastik = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'signed', // Already approved
            'nomor_surat' => '001/BA-INC/TI/VII/2026',
            'qr_token' => 'token-test-double-approval',
        ]);

        $this->actingAs($this->pimpinan);

        $response = $this->patch(route('form-bastik.approve', $bastik->id));
        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /**
     * Scenario 9: Test public verification with valid QR token.
     */
    public function test_public_can_verify_valid_bastik()
    {
        $bastik = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'nomor_surat' => '001/BA-INC/TI/VII/2026',
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'signed',
            'qr_token' => 'test-validation-token-abc',
        ]);

        $response = $this->get(route('form-bastik.verify', 'test-validation-token-abc'));

        $response->assertStatus(200);
        $response->assertSee('DOKUMEN VALID');
        $response->assertSee('001/BA-INC/TI/VII/2026');
        $response->assertSee('Dokumen ini terdaftar dan telah diverifikasi melalui SI-BASTIK.');

        // Assert scan activity was logged
        $this->assertDatabaseHas('qr_validation_logs', [
            'form_bastik_id' => $bastik->id,
        ]);
    }

    /**
     * Scenario 10: Test public verification with invalid/random token.
     */
    public function test_public_verification_handles_invalid_token()
    {
        $response = $this->get(route('form-bastik.verify', 'non-existent-random-token'));

        $response->assertStatus(404);
        $response->assertSee('DOKUMEN TIDAK DAPAT DIVERIFIKASI');
        $response->assertDontSee('SQLSTATE');
    }

    /**
     * Scenario 11: Test revising rejected document and approval history retention.
     */
    public function test_petugas_can_revise_and_resubmit_rejected_bastik()
    {
        $bastik = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'rejected',
            'rejection_note' => 'Mohon perbaiki detail tiket.',
            'qr_token' => 'token-test-revision',
        ]);

        // Record initial rejection in history
        ApprovalHistory::create([
            'form_bastik_id' => $bastik->id,
            'user_id' => $this->pimpinan->id,
            'action' => 'REJECT',
            'from_status' => 'submitted',
            'to_status' => 'rejected',
            'note' => 'Mohon perbaiki detail tiket.',
        ]);

        $this->actingAs($this->petugas);

        // Petugas edits and resubmits
        $response = $this->patch(route('form-bastik.submit', $bastik->id));
        $response->assertRedirect();

        $bastik->refresh();
        $this->assertEquals('submitted', $bastik->status);

        // History count should be 3 (REJECT + REVISE + SUBMIT)
        $this->assertCount(3, $bastik->approvalHistories);

        $actions = $bastik->approvalHistories->pluck('action')->toArray();
        $this->assertContains('REJECT', $actions);
        $this->assertContains('REVISE', $actions);
        $this->assertContains('SUBMIT', $actions);
    }

    /**
     * Scenario 12: Test downloading PDF of signed BASTIK.
     */
    public function test_can_download_pdf_for_signed_bastik()
    {
        $bastik = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'nomor_surat' => '001/BA-INC/TI/VII/2026',
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'signed',
            'qr_token' => 'token-test-pdf-download',
        ]);

        $this->actingAs($this->petugas);

        $response = $this->get(route('form-bastik.download-pdf', $bastik->id));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    /**
     * Scenario 13: Test that downloading Word (DOCX) of signed BASTIK is blocked (403).
     */
    public function test_cannot_download_docx_for_signed_bastik()
    {
        $bastik = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'nomor_surat' => '001/BA-INC/TI/VII/2026',
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'signed',
            'qr_token' => 'token-test-docx-download',
        ]);

        $this->actingAs($this->petugas);

        $response = $this->get(route('form-bastik.download-docx', $bastik->id));
        $response->assertStatus(403);
    }

    /**
     * Scenario 14: Test downloading PDF for draft/submitted BASTIK.
     */
    public function test_can_download_pdf_for_submitted_bastik()
    {
        $bastik = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'submitted',
            'qr_token' => 'token-test-pdf-submitted',
        ]);

        $this->actingAs($this->petugas);

        $response = $this->get(route('form-bastik.download-pdf', $bastik->id));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    /**
     * Scenario 15: Test downloading Word for draft/submitted BASTIK.
     */
    public function test_can_download_docx_for_submitted_bastik()
    {
        $bastik = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'submitted',
            'qr_token' => 'token-test-docx-submitted',
        ]);

        $this->actingAs($this->petugas);

        $response = $this->get(route('form-bastik.download-docx', $bastik->id));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    }

    /**
     * Security Test 16: IDOR Protection on PDF Download.
     */
    public function test_unauthorized_user_cannot_download_pdf()
    {
        $otherPetugas = User::create([
            'name' => 'Other Petugas',
            'username' => 'other_petugas',
            'email' => 'other@kai.id',
            'role' => 'petugas',
            'nip_kwt' => 'KWT999',
            'password' => bcrypt('password'),
        ]);

        $bastik = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'submitted',
            'qr_token' => 'token-test-pdf-idor',
        ]);

        $this->actingAs($otherPetugas);

        $response = $this->get(route('form-bastik.download-pdf', $bastik->id));
        $response->assertStatus(403);
    }

    /**
     * Security Test 17: IDOR Protection on Word Download.
     */
    public function test_unauthorized_user_cannot_download_docx()
    {
        $otherPetugas = User::create([
            'name' => 'Other Petugas 2',
            'username' => 'other_petugas_2',
            'email' => 'other2@kai.id',
            'role' => 'petugas',
            'nip_kwt' => 'KWT998',
            'password' => bcrypt('password'),
        ]);

        $bastik = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'submitted',
            'qr_token' => 'token-test-docx-idor',
        ]);

        $this->actingAs($otherPetugas);

        $response = $this->get(route('form-bastik.download-docx', $bastik->id));
        $response->assertStatus(403);
    }

    /**
     * Security Test 18: IDOR Protection on Lampiran (Attachment).
     */
    public function test_unauthorized_user_cannot_open_lampiran()
    {
        $otherPetugas = User::create([
            'name' => 'Other Petugas 3',
            'username' => 'other_petugas_3',
            'email' => 'other3@kai.id',
            'role' => 'petugas',
            'nip_kwt' => 'KWT997',
            'password' => bcrypt('password'),
        ]);

        $bastik = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'submitted',
            'qr_token' => 'token-test-lampiran-idor',
        ]);

        $lampiran = \App\Models\FormBastik\FormBastikLampiran::create([
            'form_bastik_id' => $bastik->id,
            'file_path' => 'lampirans/test.png',
            'original_name' => 'test.png',
            'urutan_konfirmasi' => 1,
        ]);

        $this->actingAs($otherPetugas);

        $response = $this->get(route('form-bastik.lampiran.open', $lampiran->id));
        $response->assertStatus(403);
    }

    /**
     * Security Test 19: Creator Can Open Lampiran.
     */
    public function test_creator_can_open_lampiran()
    {
        \Illuminate\Support\Facades\Storage::fake('public');
        \Illuminate\Support\Facades\Storage::disk('public')->put('lampirans/test.png', 'fake-image-content');

        $bastik = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'submitted',
            'qr_token' => 'token-test-lampiran-creator',
        ]);

        $lampiran = \App\Models\FormBastik\FormBastikLampiran::create([
            'form_bastik_id' => $bastik->id,
            'file_path' => 'lampirans/test.png',
            'original_name' => 'test.png',
            'urutan_konfirmasi' => 1,
        ]);

        $this->actingAs($this->petugas);

        $response = $this->get(route('form-bastik.lampiran.open', $lampiran->id));
        $response->assertStatus(200);
    }

    /**
     * Security Test 20: Assigned Pimpinan Can Access Assigned Document.
     */
    public function test_assigned_pimpinan_can_access_document()
    {
        $bastik = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'submitted',
            'qr_token' => 'token-test-pimpinan-assigned',
        ]);

        $this->actingAs($this->pimpinan);

        $response = $this->get(route('form-bastik.show', $bastik->id));
        $response->assertStatus(200);
    }

    /**
     * Security Test 21: Unassigned Pimpinan Cannot Access Other Pimpinan's Document.
     */
    public function test_unassigned_pimpinan_cannot_access_other_pimpinan_document()
    {
        $bastik = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'submitted',
            'qr_token' => 'token-test-pimpinan-unassigned',
        ]);

        // Login as Pimpinan B (Ahmad Pimpinan)
        $this->actingAs($this->pimpinan2);

        // Show detail -> 403
        $responseShow = $this->get(route('form-bastik.show', $bastik->id));
        $responseShow->assertStatus(403);

        // Download PDF -> 403
        $responsePdf = $this->get(route('form-bastik.download-pdf', $bastik->id));
        $responsePdf->assertStatus(403);

        // Download Word -> 403
        $responseWord = $this->get(route('form-bastik.download-docx', $bastik->id));
        $responseWord->assertStatus(403);
    }

    /**
     * Security Test 22: Petugas Index List Only Shows Own Documents.
     */
    public function test_petugas_index_list_only_shows_own_documents()
    {
        $otherPetugas = User::create([
            'name' => 'Other Petugas Index',
            'username' => 'other_petugas_idx',
            'email' => 'other_idx@kai.id',
            'role' => 'petugas',
            'nip_kwt' => 'KWT996',
            'password' => bcrypt('password'),
        ]);

        $myDoc = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'AreaMineUnique123',
            'status' => 'submitted',
            'qr_token' => 'token-test-idx-mine',
        ]);

        $otherDoc = FormBastik::create([
            'petugas_id' => $otherPetugas->id,
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'AreaOtherUnique456',
            'status' => 'submitted',
            'qr_token' => 'token-test-idx-other',
        ]);

        $this->actingAs($this->petugas);

        $response = $this->get(route('form-bastik.index'));
        $response->assertStatus(200);
        $response->assertSee('AreaMineUnique123');
        $response->assertDontSee('AreaOtherUnique456');
    }

    /**
     * Security Test 23: Pimpinan Pending Approval List Only Shows Assigned Documents.
     */
    public function test_pimpinan_pending_approval_list_only_shows_assigned_documents()
    {
        $signerB = MasterSigner::create([
            'nama' => 'Ahmad Pimpinan',
            'nipp' => '00.9999.88',
            'jabatan' => 'Manager Ops',
        ]);

        // Doc A assigned to Signer A (Bambang Sutrisno / $this->pimpinan)
        $docA = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'AreaDocAUnique789',
            'status' => 'submitted',
            'qr_token' => 'token-test-pending-doc-a',
        ]);

        // Doc B assigned to Signer B (Ahmad Pimpinan / $this->pimpinan2)
        $docB = FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $signerB->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'AreaDocBUnique999',
            'status' => 'submitted',
            'qr_token' => 'token-test-pending-doc-b',
        ]);

        // Pimpinan A (Bambang Sutrisno) should see Doc A, NOT Doc B
        $this->actingAs($this->pimpinan);
        $responseA = $this->get(route('form-bastik.pending-approval'));
        $responseA->assertStatus(200);
        $responseA->assertSee('AreaDocAUnique789');
        $responseA->assertDontSee('AreaDocBUnique999');

        // Pimpinan B (Ahmad Pimpinan) should see Doc B, NOT Doc A
        $this->actingAs($this->pimpinan2);
        $responseB = $this->get(route('form-bastik.pending-approval'));
        $responseB->assertStatus(200);
        $responseB->assertSee('AreaDocBUnique999');
        $responseB->assertDontSee('AreaDocAUnique789');
    }

    /**
     * Security Test 24: Pimpinan Pending Approval Badge Matches Designated Scope.
     */
    public function test_pimpinan_pending_approval_badge_matches_scope()
    {
        $signerB = MasterSigner::create([
            'nama' => 'Ahmad Pimpinan',
            'nipp' => '00.9999.88',
            'jabatan' => 'Manager Ops',
        ]);

        // Doc A assigned to Signer A ($this->pimpinan)
        FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $this->signer->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'submitted',
            'qr_token' => 'token-test-badge-doc-a',
        ]);

        // Doc B assigned to Signer B ($this->pimpinan2)
        FormBastik::create([
            'petugas_id' => $this->petugas->id,
            'pimpinan_id' => $signerB->id,
            'tanggal_surat' => '2026-07-10',
            'kota' => 'Bandung',
            'business_area' => 'TI',
            'status' => 'submitted',
            'qr_token' => 'token-test-badge-doc-b',
        ]);

        // Pimpinan A ($this->pimpinan) rendering layout app should see badge count = 1 (NOT 2)
        $this->actingAs($this->pimpinan);
        $viewA = view('layouts.app')->render();
        $this->assertStringContainsString('Pending Approval', $viewA);
        $this->assertMatchesRegularExpression('/bg-amber-500[^>]*>\s*1\s*<\/span>/', $viewA);

        // Pimpinan without pending documents should see badge count = 0 (no numeric badge span rendered)
        $pimpinanNoPending = User::create([
            'name' => 'Charlie Pimpinan',
            'username' => 'charlie_pimpinan',
            'email' => 'charlie@kai.id',
            'role' => 'pimpinan',
            'nip_kwt' => '00.7777.66',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($pimpinanNoPending);
        $viewC = view('layouts.app')->render();
        $this->assertDoesNotMatchRegularExpression('/bg-amber-500[^>]*>\s*[1-9]\d*\s*<\/span>/', $viewC);
    }
}
