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

        // Enhanced fetch with retry logic
        async function fetchWithRetry(url, options, maxRetries = 3, baseDelay = 300) {
            let attempt = 0;
            
            while (attempt < maxRetries) {
                try {
                    const response = await fetch(url, options);
                    
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    
                    const data = await response.json();
                    
                    if (!data.token) throw new Error('Invalid response structure');
                    
                    return data;
                } catch (error) {
                    console.error(`Attempt ${attempt + 1} failed:`, error);
                    attempt++;
                    
                    if (attempt >= maxRetries) {
                        throw new Error(`Max retries reached: ${error.message}`);
                    }
                    
                    // Exponential backoff with jitter
                    const delay = baseDelay * Math.pow(2, attempt) + Math.random() * 100;
                    await new Promise(resolve => setTimeout(resolve, delay));
                }
            }
        }

        // Timer countdown
        const countdown = setInterval(() => {
            timeLeft--;
            timerElement.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                button.disabled = false;
                timerElement.textContent = "✓";
                statusText.innerHTML = 'Secure Link Generated Completely';
                statusSubtext.innerHTML = 'You can now proceed to link';
                button.innerHTML = `
                    <span class="relative z-10 flex items-center justify-center space-x-2">
                        <span>Access Now</span>
                        <i class="ri-arrow-right-line"></i>
                    </span>`;
            }
        }, 1000);

        // Click handler with improved error handling
        button.addEventListener('click', async () => {
            button.disabled = true;
            button.innerHTML = `
                <span class="relative z-10 flex items-center justify-center space-x-2">
                    <span>Initializing Link...</span>
                    <i class="ri-loader-4-line animate-spin"></i>
                </span>`;

            try {
                const data = await fetchWithRetry('{{ route("generate.token") }}', {
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

                // Immediate redirect upon success
                window.location.href = `{{ url("/{$accessType}/{$postSlug}") }}?token=${data.token}`;
                
            } catch (error) {
                console.error('Final attempt failed:', error);
                button.innerHTML = `
                    <span class="relative z-10 flex items-center justify-center space-x-2 text-red-600">
                        <span>Connection Error - Click to Retry</span>
                        <i class="ri-refresh-line"></i>
                    </span>`;
                button.disabled = false;
                
                // Update status messages
                statusText.innerHTML = 'Connection Interrupted';
                statusSubtext.innerHTML = 'Please check your network and try again';
            }
        });
    </script>
    {!! $settings->ad2 !!}
</body>
</html>