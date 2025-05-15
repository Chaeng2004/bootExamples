document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('LogformId');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;

        // Basic front-end validation
        if (!email || !password) {
            alert("Please fill in both fields.");
            return;
        }

        try {
            const response = await fetch('signIn.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email, password })
            });

            // Check if response is OK
            if (!response.ok) {
                const text = await response.text(); // read response for debugging
                console.error("HTTP error response:", response.status, text);
                alert("Server returned an error. Check console for details.");
                return;
            }

            const result = await response.json(); // Parse JSON

            console.log("Server response:", result);

            alert(result.message);

            if (result.success) {
                window.location.href = "index.php"; // or wherever you want to redirect
            }

        } catch (error) {
            console.error("Fetch error:", error);
            alert("A network error occurred. Please try again.");
        }
    });
});
