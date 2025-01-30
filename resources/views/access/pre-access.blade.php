<div id="timer" class="text-xl mb-4">10 seconds remaining</div>
<button id="getAccessBtn" 
        class="bg-blue-500 text-white px-4 py-2 rounded disabled:opacity-50"
        disabled>
    Get Access
</button>

<script>
const timerElement = document.getElementById('timer');
const button = document.getElementById('getAccessBtn');
let timeLeft = 10;

const countdown = setInterval(() => {
    timeLeft--;
    timerElement.textContent = `${timeLeft} seconds remaining`;
    
    if (timeLeft <= 0) {
        clearInterval(countdown);
        button.disabled = false;
        timerElement.textContent = 'Ready!';
    }
}, 1000);

button.addEventListener('click', async () => {
    button.disabled = true;
    button.textContent = 'Processing...';
    
    try {
        const response = await fetch('/generate-token', {
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
            window.location.href = `{{ url("/{$accessType}/{$postSlug}") }}?token=${data.token}`;
        } else {
            alert(data.message || 'Error generating token');
            button.disabled = false;
            button.textContent = 'Get Access';
        }
    } catch (error) {
        alert('Network error');
        button.disabled = false;
        button.textContent = 'Get Access';
    }
});
</script>