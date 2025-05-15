
document.getElementById('formId').addEventListener('submit', function(e) {
    e.preventDefault(); // Stop normal form submission

    const data = {
        firstName: document.getElementById('firstName').value.trim(),
        lastName: document.getElementById('lastName').value.trim(),
        email: document.getElementById('email').value.trim(),
        password: document.getElementById('password').value
    };

    fetch('registration.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
        alert(result.message);
        if (result.success) {
            // Optional: redirect to login page or clear form
            window.location.href = "LogIn.php";
        }
    })
    .catch(err => {
        console.error('Fetch error:', err);
        alert('Something went wrong. Please try again.');
    });
});

