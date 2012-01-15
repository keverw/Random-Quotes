</div>
<div id="footer" class="clearfix">
					<div id="footer_left">
								<p>&copy;<?=date("Y")?> <?=$mastertitle?> - Script by <a href="http://kevinwhitman.com/" title="Kevin Whitman" target="_blank">Kevin Whitman</a></p>
					</div>
					<div id="footer_right">
						<ul>
							<li><a href="/privacy" title="Privacy Policy">Privacy Policy</a></li>
						</ul>
					</div>
			</div>
		</div>    
        <?php
        if ($jsAlert)
        {
            echo '<script type="text/javascript">
                    alert("' . $jsAlert . '");
                </script>';
        }
        ?>
	</body>
</html>