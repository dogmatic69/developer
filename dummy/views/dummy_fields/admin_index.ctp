<?php echo $this->Infinitas->adminIndexHead(); ?>
<div class="table">
    <table class="listing" cellpadding="0" cellspacing="0">
		<?php
            echo $this->Infinitas->adminTableHeader(
                array(
					__('Name', true),
					__('Type', true),
					__('Allow Null', true),
					__('Default', true),
					__('Min', true),
					__('Max', true),
					__('Type', true),
					__('Actions', true)
				)
			);

			$i = 1;
			foreach ($data['DummyField'] as $dummyField){
				if ($dummyField['active']) {
					?>
						<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
							<td><?php echo $dummyField['name']; ?>&nbsp;</td>
							<td style="text-align:left">
								<?php
								if ($editable && false !== strpos($dummyField['generator'], '->')) {
									echo $form->create('DummyField', array('url' => array('action'=>'change', $data['DummyTable']['id'])));

									echo $form->hidden('DummyField.id', array('value' => $dummyField['id']));
									echo $form->select('DummyField.generator', $types[$dummyField['type']], $dummyField['generator'], array('onchange' => 'submit()'), false);

									echo $form->end();
								}

								else {
									echo $dummyField['generator'];
								}
								?>&nbsp;
							</td>
							<td><?php echo $dummyField['allow_null'] == true ?  __('YES', true) : __('No', true); ?>&nbsp;</td>
							<td><?php echo $dummyField['default']; ?>&nbsp;</td>
							<td><?php echo $dummyField['custom_min']; ?>&nbsp;</td>
							<td><?php echo $dummyField['custom_max']; ?>&nbsp;</td>
							<td><?php echo $dummyField['custom_variable']; ?>&nbsp;</td>
							<td class="actions">
								<?php
									if ($editable) {
										echo $html->link(__('Deactivate', true), array('action'=>'deactivate', $dummyField['id'], 'admin' => true)),
										' ',
										$html->link(__('Edit', true), array('action'=>'edit', $dummyField['id']));
									}
								?>&nbsp;
							</td>
						</tr>
					<?php  
				}
			}
		?>
	</table>

	<h4><?php __('Inactive'); ?></h4>
    <table class="listing" cellpadding="0" cellspacing="0">
		<?php
            echo $this->Infinitas->adminTableHeader(
                array(
					__('Name', true),
					__('Default', true),
					__('Actions', true)
				)
			);

			$i = 1;
			foreach ($data['DummyField'] as $dummyField){
				if (!$dummyField['active'] ) {
					?>
						<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
							<td><?php echo $dummyField['name']; ?></td>
							<td><?php echo $dummyField['default']; ?></td>
							<td class="actions">
								<?php
									if ($editable) {
										echo $html->link(__('Activate', true), array('action'=>'activate', $dummyField['id'], 'admin' => true));
									}
								?>
							</td>
						</tr>
					<?php					
				}
			}
		?>
	</table>

<?php
if (sizeof($contents)) { ?>
	<h4><?php __('Current Content Sample'); ?></h4>
    <table class="listing" cellpadding="0" cellspacing="0">
		<?php
			$tds = array();
			foreach ($contents[0]['Model'] as $key => $value) {
				$tds[] = $key;
			}
			echo $this->Infinitas->adminTableHeader($tds);

			$i = 1;
			foreach ($contents as $one){
				$row = $one['Model'];
				?>
					<tr class="<?php echo $this->Infinitas->rowClass(); ?>">
						<?php
							foreach ($row as $field){
								echo '<td>', $this->Text->truncate(htmlspecialchars($field), 200), '</td>';
							}
						?>
					</tr>
				<?php
			};
		?>
	</table>	
	<?php 
	echo $form->end();
} else {
	echo '<p>'; 
	__('No contents yet. Generate some.');
	echo '</p>';
} ?>
</div>