document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar on mobile
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('sidebar-active');
        });
    }
    
    // Toggle submenus
    const menuItems = document.querySelectorAll('.sidebar-item');
    
    menuItems.forEach(item => {
        const link = item.querySelector('a');
        const subMenu = item.querySelector('.sub-menu');
        
        if (subMenu) {
            link.addEventListener('click', function(e) {
                if (link.getAttribute('href') === '#') {
                    e.preventDefault();
                }
                
                item.classList.toggle('open');
            });
        }
    });
    
    // Auto-expand current menu item
    const currentPath = window.location.pathname;
    
    menuItems.forEach(item => {
        const links = item.querySelectorAll('a');
        
        links.forEach(link => {
            const href = link.getAttribute('href');
            
            if (href && currentPath.includes(href) && href !== '#') {
                item.classList.add('active');
                
                // If this is a submenu item, also open the parent
                const parentItem = link.closest('.sub-menu')?.closest('.sidebar-item');
                if (parentItem) {
                    parentItem.classList.add('open', 'active');
                }
            }
        });
    });
}); 