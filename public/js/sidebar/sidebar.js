// =====================
// Mobile sidebar toggle
// =====================
document.getElementById('sidebarToggle')?.addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('show');
});

// =====================
// Navigation handling
// =====================
document.querySelectorAll('[data-section]').forEach(link => {
    link.addEventListener('click', function(e) {
        const href = this.getAttribute('href');

        // If the link has a real href (like /employees or /dashboard), allow normal navigation
        if (href && href !== '#' && !href.startsWith('javascript')) {
            // Remove active class from all links for UI consistency
            document.querySelectorAll('#sidebar .nav-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            return; // Let browser handle the navigation
        }

        // Otherwise (for fake or SPA-style links), prevent default and handle manually
        e.preventDefault();

        // Remove active class from all links
        document.querySelectorAll('#sidebar .nav-link').forEach(l => l.classList.remove('active'));

        // Add active class to clicked link
        this.classList.add('active');

        // Placeholder for custom JS content loading (if needed)
        console.log('Navigate to section:', this.dataset.section);
    });
});
