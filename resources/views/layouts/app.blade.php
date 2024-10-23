<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')
            <!-- ใส่ script ที่นี่ -->
    <script>
        document.getElementById('province-dropdown').addEventListener('change', function () {
            var provinceId = this.value;
            var amphureDropdown = document.getElementById('amphure-dropdown');
            var tambonDropdown = document.getElementById('tambon-dropdown');
            var zipCodeField = document.getElementById('zip_code');
            
            // ล้างค่าอำเภอ, ตำบล, และรหัสไปรษณีย์เมื่อเลือกจังหวัดใหม่
            amphureDropdown.innerHTML = '<option value="">Select Amphure</option>';
            tambonDropdown.innerHTML = '<option value="">Select Tambon</option>';
            zipCodeField.value = '';

            if (provinceId) {
                // ดึงข้อมูลอำเภอตามจังหวัด
                fetch(`/admin/amphures/${provinceId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(function (amphure) {
                            var option = document.createElement('option');
                            option.value = amphure.id;
                            option.text = amphure.name_th;
                            amphureDropdown.appendChild(option);
                        });
                    });
            }
        });

        document.getElementById('amphure-dropdown').addEventListener('change', function () {
            var amphureId = this.value;
            var tambonDropdown = document.getElementById('tambon-dropdown');
            var zipCodeField = document.getElementById('zip_code');

            tambonDropdown.innerHTML = '<option value="">Select Tambon</option>';
            zipCodeField.value = '';

            if (amphureId) {
                // ดึงข้อมูลตำบลตามอำเภอ
                fetch(`/admin/tambons/${amphureId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(function (tambon) {
                            var option = document.createElement('option');
                            option.value = tambon.id;
                            option.text = tambon.name_th;
                            tambonDropdown.appendChild(option);
                        });
                    });
            }
        });

        document.getElementById('tambon-dropdown').addEventListener('change', function () {
            var tambonId = this.value;

            if (tambonId) {
                // ดึงรหัสไปรษณีย์ตามตำบล
                fetch(`/admin/zipcode/${tambonId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('zip_code').value = data.zip_code;
                    });
            }
        });
    </script>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
