<div class="wrap">
	
	<?php screen_icon( 'themes' ); ?>

	<h2>Your Subscribers</h2>
	<div id="poststuff">
	
		<div id="post-body" class="metabox-holder">
		
			<!-- main content -->
			<div id="post-body-content">

				<form method="post" action="?page=<?php echo esc_html( $_GET['page'] ); ?>">
                <input name="crum_remove" value="1" type="hidden" />
            			<?php 
						if ($_SERVER['REQUEST_METHOD']=="POST" and $_POST['crum_remove']) {
							if ($_GET['rem']) $_POST['rem'][] = $_GET['rem'];
							$count = 0;
							if (is_array($_POST['rem'])) {
								foreach ($_POST['rem'] as $id) { 
									$wpdb->query("delete from ".$wpdb->prefix."crumsubscribe where id = '".$wpdb->escape($id)."' limit 1");
									$count++; 
								}
								$message = $count." subscribers have been removed successfully.";
							}
						}
						
						if ($_SERVER['REQUEST_METHOD']=="POST" and $_POST['crum_import']) {
							$correct = 0;
							if($_FILES['file']['tmp_name']) {
								if(!$_FILES['file']['error'])  {
									$file = file_get_contents ($_FILES['file']['tmp_name']);
									$lines = preg_split('/\r\n|\r|\n/', $file);
									if (count($lines)) {
										$sql = array();
										foreach ($lines as $data) {
											$data = explode(',', $data);
											$num = count($data);
											$row++;
											
											if (is_email(trim($data[0]))) {
												$c = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."crumsubscribe where crum_email LIKE '".$wpdb->escape(trim($data[0]))."' limit 1", ARRAY_A);
												if (!is_array($c)) {											
													$wpdb->query("INSERT INTO ".$wpdb->prefix."crumsubscribe (crum_email) VALUES ('".$wpdb->escape(trim($data[0]))."')");
													$correct++;
												} else { $exists++; }
											} else { $invalid++; }
										}
										
									} else { $message = 'Oh no! Your CSV file does not apear to be valid, please check the format and upload again.'; }
								
									if (!$message) {
										$message = $correct.' records have been imported. '.($invalid?$invalid.' could not be imported due to invalid email addresses. ':'').($exists?$exists.' already exists. ':'');
									}
								
								} else {
									$message = 'Ooops! There seems to of been a problem uploading your csv';
								}
							}								
						}
						//echo $sql;
						if ($message) { echo '<div style="padding: 5px;" class="updated"><p>'.$message.'</p></div>'; }
						
            			?>
					
	
						<table cellspacing="0" class="wp-list-table widefat fixed subscribers">
                          <thead>
                            <tr>
                                <th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
	                            <th style="" class="manage-column column-email" id="email" scope="col"><span><?php esc_html_e('Email Address','polo_extension')?></span><span class="sorting-indicator"></span></th>
                                <!--<th style="" class="manage-column column-name" id="name" scope="col">Name<span class="sorting-indicator"></span></th>-->
                            </thead>
                        
                            <tfoot>
                            <tr>
                                <th style="" class="manage-column column-cb check-column" scope="col"><input type="checkbox"></th>
	                            <th style="" class="manage-column column-email" scope="col"><span><?php esc_html_e('Email Address','polo_extension')?></span><span class="sorting-indicator"></span></th>
                                <!--<th style="" class="manage-column column-name" scope="col"><span>Name</span><span class="sorting-indicator"></span></th>-->
                            </tfoot>
                        
                            <tbody id="the-list">
                            
                            <?php 
                            
								$results = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."crumsubscribe");
								if (count($results)<1) echo '<tr class="no-items"><td colspan="3" class="colspanchange">'.esc_html__('No mailing list subscribers have been added.','polo_extension').'</td></tr>';
								else {
									foreach($results as $row) {
	
										echo '<tr>
													<th class="check-column" style="padding:5px 0 2px 0"><input type="checkbox" name="rem[]" value="'.esc_js(esc_html($row->id)).'"></th>
													<td>'.esc_js(esc_html($row->crum_email)).'</td>';
													/*<td>'.esc_js(esc_html($row->crum_name)).'</td>*/
											  echo '</tr>';
									}
								}
							?>

                            </tbody>
                        </table>
                        <br class="clear">
						<input class="button" name="submit" type="submit" value="Remove Selected" /> <a class="button" href="<?php echo PLUGIN_URL.'inc/subscribe-form/export-csv.php'; ?>"><?php esc_html_e('Export as CSV','polo_extension')?></a>
				</form>
				<br class="clear">
                
                
                <div class="meta-box-sortables">
                        <div class="postbox">
                        	
                       	  <h3><span><?php esc_html_e('Import your own CSV File','polo_extension')?></span></h3>
                          <div class="inside">
                
                <p><?php esc_html_e('This feature allows you to import your own csv (comma seperated values) file into &quot;Mail Subscribe List&quot;.','polo_extension')?></p>

                <form id="import-csv" method="post" enctype="multipart/form-data" action="?page=<?php echo ($_GET['page'] );?>">
                <input name="crum_import" value="1" type="hidden" />
                <p><label><input name="file" type="file" value="" /><?php esc_html_e(' CSV File','polo_extension')?></label></p>

                <p class="submit"><input type="submit" value="<?php esc_html_e('Upload and Import CSV File','polo_extension')?>" class="button-secondary" id="submit" name="submit"></p></form>
                </div></div></div>

			</div> 

	</div>
	
</div> 