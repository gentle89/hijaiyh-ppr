<?php
echo '   <div class="content p-4">';
		$fitur = ['antibot' => 'integrate antibot.pw api',
				  '#' => 'more feature coming soon ..'];
				  echo "<ul>";
				  $btnlist = ['success','danger','warning','primary'];
		foreach ($fitur as $link => $value) {
			$btn = $btnlist[rand(0,3)];
			echo "<li><a href='".base_url('feature/'.$link)."' class='btn btn-".$btn."'>".$value."</a></li><br>";
		}
		echo "</ul></div>";
		