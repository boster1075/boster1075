<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบแจ้งเตือนสภาพอากาศ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
        }
        .weather-card {
            transition: all 0.3s ease;
        }
        .weather-card:hover {
            transform: translateY(-5px);
        }
        .alert-badge {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.6; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <header class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold text-blue-800">ระบบแจ้งเตือนสภาพอากาศ</h1>
            <p class="text-blue-600 mt-2">ข้อมูลสภาพอากาศและการแจ้งเตือนล่าสุด</p>
        </header>

        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="p-6">
                <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800" id="current-location">กรุงเทพมหานคร</h2>
                        <p class="text-gray-500" id="current-date">กำลังโหลด...</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <div class="relative">
                            <input type="text" id="location-search" placeholder="ค้นหาตำแหน่ง..." 
                                class="pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button id="search-btn" class="absolute right-2 top-2 text-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center bg-blue-50 rounded-xl p-6">
                    <div class="flex-shrink-0 flex items-center justify-center">
                        <div id="weather-icon" class="w-24 h-24 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-0 md:ml-6 mt-4 md:mt-0 text-center md:text-left">
                        <div class="text-4xl font-bold text-gray-800" id="current-temp">32°C</div>
                        <div class="text-xl text-gray-600" id="weather-desc">แดดจัด</div>
                        <div class="mt-2 flex flex-wrap justify-center md:justify-start gap-4">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                </svg>
                                <span id="humidity">ความชื้น: 65%</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span id="wind">ลม: 10 กม./ชม.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">การแจ้งเตือนล่าสุด</h2>
            <div id="alerts-container" class="space-y-4">
                <div class="bg-red-100 border-l-4 border-red-500 rounded-lg p-4 flex items-start">
                    <div class="flex-shrink-0 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-red-800">คำเตือน: ฝนตกหนัก</h3>
                        <p class="text-red-700 mt-1">คาดการณ์ฝนตกหนักในพื้นที่กรุงเทพฯ และปริมณฑล ระหว่างเวลา 15:00-18:00 น.</p>
                        <p class="text-sm text-red-600 mt-2">ออกเมื่อ: 10:30 น. วันนี้</p>
                    </div>
                </div>
                <div class="bg-yellow-100 border-l-4 border-yellow-500 rounded-lg p-4 flex items-start">
                    <div class="flex-shrink-0 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-yellow-800">คำเตือน: อากาศร้อนจัด</h3>
                        <p class="text-yellow-700 mt-1">อุณหภูมิสูงถึง 38°C ในช่วงบ่าย ควรหลีกเลี่ยงกิจกรรมกลางแจ้งและดื่มน้ำให้เพียงพอ</p>
                        <p class="text-sm text-yellow-600 mt-2">ออกเมื่อ: 08:15 น. วันนี้</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">พยากรณ์อากาศ 5 วัน</h2>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <!-- Forecast cards will be generated here -->
            </div>
        </div>

        <div class="max-w-4xl mx-auto mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">ตั้งค่าการแจ้งเตือน</h2>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="alert-type">ประเภทการแจ้งเตือน</label>
                    <select id="alert-type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="rain">ฝนตก</option>
                        <option value="temperature">อุณหภูมิสูง/ต่ำ</option>
                        <option value="storm">พายุ</option>
                        <option value="all">ทั้งหมด</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="alert-method">วิธีการแจ้งเตือน</label>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input type="checkbox" id="alert-browser" class="mr-2" checked>
                            <label for="alert-browser">การแจ้งเตือนบนเบราว์เซอร์</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="alert-email" class="mr-2">
                            <label for="alert-email">อีเมล</label>
                        </div>
                    </div>
                </div>
                <div class="mb-4" id="email-input-container" style="display: none;">
                    <label class="block text-gray-700 mb-2" for="email">อีเมลของคุณ</label>
                    <input type="email" id="email" placeholder="your@email.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button id="save-alerts" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">บันทึกการตั้งค่า</button>
            </div>
        </div>
    </div>

    <footer class="bg-blue-800 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>© 2023 ระบบแจ้งเตือนสภาพอากาศ</p>
            <p class="text-blue-200 mt-2">ข้อมูลสภาพอากาศจำลองเพื่อการสาธิตเท่านั้น</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set current date
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('current-date').textContent = now.toLocaleDateString('th-TH', options);

            // Generate forecast cards
            const forecastContainer = document.querySelector('.grid');
            const days = ['จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์'];
            const weatherTypes = [
                { icon: '☀️', desc: 'แดดจัด', temp: '33°C' },
                { icon: '🌦️', desc: 'ฝนตกเล็กน้อย', temp: '30°C' },
                { icon: '⛈️', desc: 'ฝนฟ้าคะนอง', temp: '28°C' },
                { icon: '☁️', desc: 'มีเมฆมาก', temp: '31°C' },
                { icon: '🌤️', desc: 'เมฆบางส่วน', temp: '32°C' }
            ];

            days.forEach((day, index) => {
                const weather = weatherTypes[index];
                const card = document.createElement('div');
                card.className = 'weather-card bg-white rounded-lg shadow-md p-4 text-center';
                card.innerHTML = `
                    <h3 class="font-medium text-gray-800">${day}</h3>
                    <div class="text-4xl my-2">${weather.icon}</div>
                    <div class="text-xl font-bold text-gray-800">${weather.temp}</div>
                    <div class="text-sm text-gray-600">${weather.desc}</div>
                `;
                forecastContainer.appendChild(card);
            });

            // Handle alert method selection
            const emailCheckbox = document.getElementById('alert-email');
            const emailContainer = document.getElementById('email-input-container');
            
            emailCheckbox.addEventListener('change', function() {
                emailContainer.style.display = this.checked ? 'block' : 'none';
            });

            // Handle save alerts button
            document.getElementById('save-alerts').addEventListener('click', function() {
                const alertType = document.getElementById('alert-type').value;
                const browserAlert = document.getElementById('alert-browser').checked;
                const emailAlert = document.getElementById('alert-email').checked;
                const email = document.getElementById('email').value;
                
                let message = 'บันทึกการตั้งค่าเรียบร้อย!';
                
                if (emailAlert && !email) {
                    message = 'กรุณากรอกอีเมลของคุณ';
                } else {
                    // Show notification
                    showNotification('บันทึกการตั้งค่าเรียบร้อย', 'คุณจะได้รับการแจ้งเตือนเมื่อมีสภาพอากาศที่ตรงกับเงื่อนไขที่คุณเลือก');
                }
                
                alert(message);
            });

            // Search location functionality
            document.getElementById('search-btn').addEventListener('click', function() {
                const location = document.getElementById('location-search').value;
                if (location.trim() !== '') {
                    document.getElementById('current-location').textContent = location;
                    // Simulate loading new weather data
                    simulateWeatherChange();
                    showNotification('เปลี่ยนตำแหน่งสำเร็จ', `แสดงข้อมูลสภาพอากาศสำหรับ ${location}`);
                }
            });

            // Function to simulate weather change
            function simulateWeatherChange() {
                const temps = ['28°C', '30°C', '32°C', '34°C', '29°C'];
                const descriptions = ['แดดจัด', 'มีเมฆบางส่วน', 'ฝนตกเล็กน้อย', 'ท้องฟ้าโปร่ง', 'มีเมฆมาก'];
                const humidities = ['65%', '70%', '75%', '60%', '80%'];
                const winds = ['10 กม./ชม.', '15 กม./ชม.', '8 กม./ชม.', '12 กม./ชม.', '5 กม./ชม.'];
                
                const randomIndex = Math.floor(Math.random() * temps.length);
                
                document.getElementById('current-temp').textContent = temps[randomIndex];
                document.getElementById('weather-desc').textContent = descriptions[randomIndex];
                document.getElementById('humidity').textContent = `ความชื้น: ${humidities[randomIndex]}`;
                document.getElementById('wind').textContent = `ลม: ${winds[randomIndex]}`;
                
                // Change weather icon based on description
                const weatherIcon = document.getElementById('weather-icon');
                if (descriptions[randomIndex].includes('ฝน')) {
                    weatherIcon.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                        </svg>
                    `;
                } else if (descriptions[randomIndex].includes('เมฆ')) {
                    weatherIcon.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                        </svg>
                    `;
                } else {
                    weatherIcon.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    `;
                }
            }

            // Function to show notification
            function showNotification(title, message) {
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-blue-600 text-white p-4 rounded-lg shadow-lg z-50 max-w-xs';
                notification.innerHTML = `
                    <div class="font-bold">${title}</div>
                    <div class="text-sm mt-1">${message}</div>
                `;
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.style.opacity = '0';
                    notification.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 500);
                }, 3000);
            }
        });
    </script>
</body>
</html>