@include('form-monitoring-isi-rak-dc-drc.form', [
    'action' => route('form-monitoring-isi-rak-dc-drc.store'),
    'method' => 'POST',
    'form' => new \App\Models\FormMonitoringIsiRakDcDrc\FormMonitoringIsiRakDcDrc()
])
