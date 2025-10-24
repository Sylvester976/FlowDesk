// Mobile sidebar toggle
document.getElementById('sidebarToggle')?.addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('show');
});

// Navigation handling
document.querySelectorAll('[data-section]').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();

        // Remove active class from all links
        document.querySelectorAll('#sidebar .nav-link').forEach(l => l.classList.remove('active'));

        // Add active class to clicked link
        this.classList.add('active');

        // Here you would typically load different content based on the section
        console.log('Navigate to:', this.dataset.section);
    });
});
