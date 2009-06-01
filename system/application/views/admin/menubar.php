<div id="menubar">
	<ul>
		
		<li class="home"><a href="<?=site_url() ?>">Home</a></li>
		<li class="books"><a href="<?=site_url() ?>admin/books">Book</a></li>
		<li class="members"><a href="<?=site_url() ?>admin/members">Member</a></li>
		<li class="config"><a href="<?=site_url() ?>admin/config">Setting</a></li>		
		<li class="none">
			<?php
			if($this->uri->segment(2) != "login"){
		?>
		<span>Hello </span> <span class="username"><?=get_cookie("username")?></span>, <a href="<?=site_url() ?>admin/login/out">Logout</a>						
		<?php
			}
		?>
		</li>
	</ul>
</div>