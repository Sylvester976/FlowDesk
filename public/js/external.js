(function () {
    const INACTIVITY_LIMIT = 15 * 60 * 1000; // 3 seconds for testing, change to 5 mins in production
    let inactivityTimer;

    function logoutUser() {
        if (!window.appConfig) return;

        Swal.fire({
            icon: 'warning',
            title: 'Logged Out',
            text: 'You have been logged out due to inactivity.',
            confirmButtonText: 'OK'
        }).then(() => {
            const formData = new FormData();
            formData.append('_token', window.appConfig.csrfToken);

            navigator.sendBeacon(window.appConfig.logoutUrl, formData);
            window.location.href = window.appConfig.loginUrl;
        });
    }

    function resetTimer() {
        clearTimeout(inactivityTimer);
        inactivityTimer = setTimeout(logoutUser, INACTIVITY_LIMIT);
    }

    // Listen for user activity
    ['click', 'mousemove', 'keydown', 'scroll', 'touchstart'].forEach(event => {
        window.addEventListener(event, resetTimer);
    });

    // Start inactivity timer
    resetTimer();
})();



function goBack() {
    window.history.back();
}

//email checker
$('#emailInput').on('input', function () {
    const email = $(this).val();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
    const feedback = $('#emailFeedback');

    if (!email) feedback.text('').removeClass();
    else if (emailRegex.test(email)) feedback.text('Looks good!').removeClass().addClass('form-text text-success');
    else feedback.text('Please enter a valid email like name@example.com').removeClass().addClass('form-text text-danger');
});


$(document).ready(function () {
    $('#attachment_type').select2({
        placeholder: "Select Attachment Type(s)",
        width: '100%'
    });
});

$(document).ready(function () {
    $('#leavetype_select2').select2({
        placeholder: "Select type of leave",
        width: '100%'
    });
});








