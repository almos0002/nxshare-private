<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nxshare Access Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="https://i.postimg.cc/4dbDJLpG/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@100;200;300;400;500;600;700;800;900&display=swap");
        @keyframes orbit {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes starburst {
            0% { transform: scale(0); opacity: 1; }
            100% { transform: scale(8); opacity: 0; }
        }
        html, body{
            font-family: "Barlow Condensed", sans-serif;
        }
        .solar-bg {
            background: radial-gradient(ellipse at bottom, #FFFFFF 0%, #F3F4F6 100%);
        }

        .sky-overlay {
            background: 
                radial-gradient(circle at 20% 20%, #FDE68A55 0%, transparent 40%),
                radial-gradient(circle at 80% 80%, #93C5FD55 0%, transparent 40%);
        }

        .orbit-container {
            position: relative;
            width: 160px;
            height: 160px;
        }

        .moon-orbit {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            animation: orbit 8s linear infinite;
        }

        .moon-trail {
            position: absolute;
            width: 100%;
            height: 100%;
            border: 2px dashed #F59E0B33;
            border-radius: 50%;
        }

        .moon {
            position: absolute;
            top: -10px;
            left: 50%;
            width: 20px;
            height: 20px;
            background: #F3F4F6;
            border-radius: 50%;
            box-shadow: 0 0 10px #FFFFFF,
                        inset 0 0 8px #CBD5E1;
            transform: translateX(-50%);
        }

        .sun-loader {
            background: radial-gradient(circle at center, #FEF3C7 60%, #FDE68A 100%);
            box-shadow: 0 0 50px #F59E0B55;
            width: 100px;
            height: 100px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body class="solar-bg min-h-screen flex items-center justify-center p-4 overflow-hidden">
    <!-- Sky Overlay -->
    <div class="fixed inset-0 sky-overlay pointer-events-none"></div>

    <div class="relative z-10 bg-white/50 backdrop-blur-lg rounded-2xl p-8 max-w-md w-full border border-gray-200/50">
        <div class="text-center space-y-8">
            <!-- Orbit Container -->
            <div class="flex justify-center">
                <div class="orbit-container">
                    <div class="moon-orbit">
                        <div class="moon-trail"></div>
                        <div class="moon"></div>
                    </div>
                    <div class="sun-loader rounded-full">
                        <div id="timer" class="absolute inset-0 flex items-center justify-center text-3xl font-bold text-amber-600">10</div>
                    </div>
                </div>
            </div>

            <!-- Solar Status -->
            <div class="space-y-2">
                <h2 id="statusText" class="text-xl font-semibold text-gray-800">Generating Your Secure Link</h2>
                <p id="statusSubtext" class="text-sm text-gray-600">Please wait for a while...</p>
            </div>

            <!-- Launch Button -->
            <button id="getAccessBtn" 
                    class="w-full bg-gradient-to-r from-amber-400 to-orange-400 rounded-xl py-4 px-8
                           text-gray-800 hover:text-gray-900 hover:shadow-2xl hover:from-amber-300 hover:to-orange-300
                           transition-all duration-300 disabled:opacity-50 disabled:hover:shadow-none
                           group relative overflow-hidden" disabled>
                <span class="relative z-10 flex items-center justify-center space-x-2">
                    <span>Please Wait</span>
                    <i class="ri-loader-4-line animate-spin"></i>
                </span>
                <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </button>
        </div>
    </div>

    <script>
        const timerElement = document.getElementById('timer');
        const button = document.getElementById('getAccessBtn');
        const statusText = document.getElementById('statusText');
        const statusSubtext = document.getElementById('statusSubtext');
        let timeLeft = 10;

        // Moon orbit timer
        const countdown = setInterval(() => {
            timeLeft--;
            timerElement.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                button.disabled = false;
                timerElement.innerHTML = '<i class="ri-checkbox-circle-fill text-orange-500 text-4xl animate-pulsar"></i>';
                statusText.innerHTML = 'Secure Link Generated Completely';
                statusSubtext.innerHTML = 'You can now proceed to link';
                button.innerHTML = `
                <span class="relative z-10 flex items-center justify-center space-x-2">
                    <span>Access Now</span>
                    <i class="ri-arrow-right-line"></i>
                </span>
            `;

            }
        }, 1000);

        // Activation handler
        button.addEventListener('click', async () => {
            button.disabled = true;
            button.innerHTML = `
                <span class="relative z-10 flex items-center justify-center space-x-2">
                    <span>Initializing Link...</span>
                    <i class="ri-loader-4-line animate-spin"></i>
                </span>
            `;

            // Create burst effect
            const burst = document.createElement('div');
            burst.className = 'absolute inset-0 bg-gradient-to-r from-amber-300 to-orange-300 rounded-xl animate-starburst';
            button.appendChild(burst);
            setTimeout(() => burst.remove(), 1000);

            try {
                const response = await fetch('{{ route("generate.token") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        accessType: '{{ $accessType }}',
                        postId: {{ $postId }}
                    })
                });

                const data = await response.json();
                
                if (response.ok) {
                    button.innerHTML = `<span>Entering Secure Link...</span>`;
                    document.body.style.animation = 'warp 2s linear infinite';
                    setTimeout(() => {
                        window.location.href = `{{ url("/{$accessType}/{$postSlug}") }}?token=${data.token}`;
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Photon Overload Detected');
                }
            } catch (error) {
                // Create energy surge effect
                const explosion = document.createElement('div');
                explosion.className = 'absolute inset-0 bg-red-400/20 rounded-xl animate-starburst';
                button.appendChild(explosion);
                setTimeout(() => explosion.remove(), 1000);

                button.innerHTML = `<span class="text-red-600">Alignment Failed - Retry</span>`;
                setTimeout(() => {
                    button.disabled = false;
                    button.innerHTML = `<span>Activate Photon Drive</span>`;
                }, 2000);
            }
        });

    </script>
</body>
</html>