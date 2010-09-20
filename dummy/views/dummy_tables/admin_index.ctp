<?php echo $this->Infinitas->adminIndexHead(); ?>
<div class="table">
	<table class="listing" cellpadding="0" cellspacing="0">
		<?php
			echo $this->Infinitas->adminTableHeader(
				array(
					__('Name', true),
					__('Amount', true) => array(
						'style' => 'width:100px'
					),
					__('Actions', true) => array(
						'style' => 'width:100px'
					)
				)
			);

			$i = 1;
			$inactive = false;

			foreach ($data as $one){
				$table = $one['DummyTable'];
				if (!isset($table['active']) || (isset($table['active']) && $table['active']) ) {
					?>
						<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
							<td>
								<?php echo $html->link(Inflector::underscore($table['name']), array('controller'=>'dummy_fields', 'action'=>'index', $table['id'])); ?>
							</td>
							<td>
								<?php
									if ($editable) {
										echo $form->create('DummyTable',array(
										'style' => 'width:100%;margin:0;',
										'url' => array('action'=>'number',$table['id'])));

										echo $form->text('DummyTable.number',array(
											'value' => $table['number'],
											'style'=>'width:100%',
											'onchange' => 'submit()'
										));
										echo $form->end();
									} else {
										echo $table['number'] ;
									} ?>
							</td>
							<td>
								<?php
									 echo $html->link(__('Generate',true), array('action'=>'generate', $table['id']));
								if ($editable) {
									echo ' '.$html->link(__('Deactivate',true), array('action'=>'deactivate', $table['id']));
								}
								?>
							</td>
						</tr>
					<?php
				}

				else {
					$inactive = true;
				}
			}; ?>
	</table>

	<?php
		if ($inactive) {
			?>
				<h4>Inactive tables</h4>
				<table class="listing" cellpadding="0" cellspacing="0">
					<?php
						echo $this->Infinitas->adminTableHeader(
							array(
								__('Name', true),
								__('Actions', true) => array(
									'style' => 'width:100px'
								)
							)
						);
						
						$i = 1;
						foreach ($data as $one ){
							$table = $one['DummyTable'];

							if (!$table['active']){ ?>
								<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
									<td><?php echo $html->link(Inflector::underscore($table['name']), array('controller'=>'dummy_fields', 'action'=>'index', $table['name'])); ?></td>
									<td>
										<?php
											if ($editable) {
												echo $html->link(__('Activate',true), array('action'=>'activate', $table['id']));
											}
										?>&nbsp;
									</td>
								</tr><?php
							}
						}
					?>
				</table>
			<?php
		}
	?>
</div>