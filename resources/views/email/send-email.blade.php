<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>کد فعال سازی</title>
</head>

<body dir="rtl">
    <main style="height: 100vh; display: flex; align-items: center; justify-content: center;">
        <div style="width: 100%;">
            <div
                style="max-width: 24rem; margin-left: auto; margin-right: auto; background-color: #F3F4F6; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); padding: 0.75rem 1rem; border-radius: 0.5rem;">
                <div style="text-align: center;">
                    <span style="font-size: 1.25rem;">
                        {{ $details['title'] }}
                    </span>
                </div>
                <div style="text-align: center; margin-top: 1.25rem;">
                    {{ $details['body'] }}
                </div>
                <div style="text-align: center; margin-top: 1.25rem;">
                    تمام حقوق برای تیم <span style="color: #2563EB; font-weight: 700;">خدمات چی</span> محفوظ است
                </div>
            </div>
        </div>
    </main>
</body>

</html>
