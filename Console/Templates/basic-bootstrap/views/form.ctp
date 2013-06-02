<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="actions">
	<h3><?php echo "<?php echo __('Actions'); ?>"; ?></h3>
    <div class="btn-group">
      <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
        <?php echo h($singularHumanName);?>
        <span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <!-- dropdown menu links -->
        <li><?php echo "<?php echo \$this->Html->link(
            __('List " . $pluralHumanName . "'),
            array(
                'action' => 'index'
            )
        );?>";?></li><?php
    if (strpos($action, 'add') === false) {?>
    	<li><?php echo "<?php echo \$this->Html->link(
            __('New " . $singularHumanName . "'),
            array(
                'action' => 'new'
            )
        );?>";?></li>
    	<li><?php echo "<?php echo \$this->Form->postLink(
    		__('Delete'),
    		array(
    			'action' => 'delete',
    			\$this->Form->value('{$modelClass}.{$primaryKey}')),
    			null,
    			__('Are you sure you want to delete # %s?', \$this->Form->value('{$modelClass}.{$primaryKey}')
    		)
    	);?>";?></li>
    <?php
 	}
?>
      </ul>
    </div>
<?php
    $done = array();
    foreach ($associations as $type => $data) {
        foreach ($data as $alias => $details) {
            if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {?>
	<div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
            <?php echo Inflector::humanize(Inflector::underscore($alias));?>
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
        <!-- dropdown menu links -->
        <li><?php echo '<?php echo $this->Html->link(
            __(\'List ', Inflector::humanize($details['controller']) , '\'),
            array(
                \'controller\' => \'', $details['controller'], '\',
                \'action\' => \'index\'
            )
        );?>';?></li>
        <li><?php echo '<?php echo $this->Html->link(
            __(\'New ', Inflector::humanize(Inflector::underscore($alias)) , '\'),
            array(
                \'controller\' => \'', $details['controller'], '\',
                \'action\' => \'add\'
            )
        );?>';?></li><?php
                $done[] = $details['controller'];
                echo PHP_EOL, '        </div>';
            }
        }
    }
    echo PHP_EOL, '    </div>';
?>
<br />
<div class="<?php echo $pluralVar; ?> form">
<?php echo "<?php echo \$this->Form->create('{$modelClass}'); ?>\n"; ?>
	<fieldset>
		<legend><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></legend>
<?php
		echo "\t<?php\n";
		foreach ($fields as $field) {
			if (strpos($action, 'add') !== false && $field == $primaryKey) {
				continue;
			} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
				echo "\t\techo \$this->Form->input('{$field}');\n";
			}
		}
		if (!empty($associations['hasAndBelongsToMany'])) {
			foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
				echo "\t\techo \$this->Form->input('{$assocName}');\n";
			}
		}
		echo "\t?>\n";
?>
	</fieldset>
<?php
	echo "<?php echo \$this->Form->end(
		array(
			'label' => __('Submit'),
			'class' => 'btn btn-primary'
		)
	); ?>\n";
?>
</div>