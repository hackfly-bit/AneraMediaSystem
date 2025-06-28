import './bootstrap';

// Sidebar functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebar-toggle');
    const mobileToggleBtn = document.getElementById('mobile-sidebar-toggle');
    const overlay = document.getElementById('sidebar-overlay');
    
    // Desktop sidebar toggle
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            sidebar.classList.toggle('expanded');
            
            // Save state to localStorage
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed);
        });
    }
    
    // Mobile sidebar toggle
    if (mobileToggleBtn && sidebar) {
        mobileToggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('mobile-open');
            if (overlay) {
                overlay.classList.toggle('hidden');
            }
        });
    }
    
    // Close sidebar when clicking overlay
    if (overlay && sidebar) {
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('mobile-open');
            overlay.classList.add('hidden');
        });
    }
    
    // Restore sidebar state from localStorage
    if (sidebar) {
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            sidebar.classList.add('collapsed');
            sidebar.classList.remove('expanded');
        } else {
            sidebar.classList.add('expanded');
            sidebar.classList.remove('collapsed');
        }
    }
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768 && sidebar) {
            sidebar.classList.remove('mobile-open');
            if (overlay) {
                overlay.classList.add('hidden');
            }
        }
    });
    
    // Active menu item highlighting
    const currentPath = window.location.pathname;
    const menuItems = document.querySelectorAll('.sidebar-item');
    
    menuItems.forEach(item => {
        const link = item.querySelector('a');
        if (link && link.getAttribute('href') === currentPath) {
            item.classList.add('active');
        }
    });
});

// Search functionality
function initializeSearch() {
    const searchInput = document.querySelector('input[placeholder="Search..."]');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            // Add search logic here if needed
            console.log('Searching for:', query);
        });
    }
}

// Initialize search when DOM is loaded
document.addEventListener('DOMContentLoaded', initializeSearch);