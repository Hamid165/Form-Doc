import pandas as pd
df = pd.read_excel('d:\\laravel\\formulir-kai\\1610594994-formulir-availability-system-ticketing.xlsx')
with open('d:\\laravel\\formulir-kai\\excel_dump.md', 'w', encoding='utf-8') as f:
    f.write(df.to_markdown())
