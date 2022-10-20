<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <?php $session = session(); ?>
        <a class="navbar-brand" href="<?php echo base_url();?>">WebsiteName</a>
        
        <ul class="navbar-nav col-12 col-lg-auto me-lg-auto mb-2 mb-md-0">
            <li><a href="#" class="nav-link">Features</a></li>
            <li><a href="#" class="nav-link">Pricing</a></li>
            <li><a href="#" class="nav-link">FAQs</a></li>
            <li><a href="#" class="nav-link">About</a></li>
        </ul>

        <div class="text-end">
            <?php if(session()->has('userID')): ?>
                <a class="btn btn-outline-primary me-2"  href="<?php echo base_url('dashboard/Profile');?>">Profile</a>
                <a class="btn btn-outline-primary me-2"  href="<?php echo base_url('auth/logout');?>">Logout</a>
            <?php else: ?>
                <a class="btn btn-outline-primary me-2" href="<?php echo base_url('auth/login');?>">Login</a>
                <a class="btn btn-outline-primary me-2" href="<?php echo base_url('auth/register');?>">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
