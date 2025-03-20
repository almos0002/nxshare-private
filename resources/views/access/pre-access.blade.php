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
        html, body{
            font-family: "Barlow Condensed", sans-serif;
            background: radial-gradient(ellipse at bottom, #ffffff 0%, #f3f4f6 100%);
        }
        .gradient{
            background: radial-gradient(
            circle at 20% 20%,
            #fde68a55 0%,
            transparent 40%
        ),
        radial-gradient(circle at 80% 80%, #93c5fd55 0%, transparent 40%);
}
        }
    </style>
</head>
<body class="min-h-screen gradient flex items-center justify-center p-4">
    <div class="text-center space-y-4">
        {!! $settings->ad1 !!}
        <!-- Timer Display -->
        <div class="flex justify-center">
            <div id="timer" class="text-6xl font-bold text-amber-500">6</div>
        </div>

        <!-- Status Text -->
        <div class="space-y-2">
            <h2 id="statusText" class="text-xl font-semibold text-gray-800">Generating Your Secure Link</h2>
            <p id="statusSubtext" class="text-sm text-gray-600">Please wait for a while...</p>
        </div>

        <!-- Launch Button -->
        <button id="getAccessBtn" 
                class="w-full bg-gradient-to-r from-amber-400 to-orange-400 py-4 px-8
                       text-gray-800 hover:text-gray-900 transition-all duration-300 disabled:opacity-50
                       group relative" disabled>
            <span class="relative z-10 flex items-center justify-center space-x-2">
                <span>Please Wait</span>
                <i class="ri-loader-4-line animate-spin"></i>
            </span>
        </button>
        {!! $settings->ad1 !!}
    </div>

    <script>
        const timerElement = document.getElementById('timer');
        const button = document.getElementById('getAccessBtn');
        const statusText = document.getElementById('statusText');
        const statusSubtext = document.getElementById('statusSubtext');
        let timeLeft = 6;

        // Moon orbit timer
        const countdown = setInterval(() => {
            timeLeft--;
            timerElement.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                button.disabled = false;
                timerElement.innerHTML = '✓';
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
    {!! $settings->ad2 !!}
</body>
</html>