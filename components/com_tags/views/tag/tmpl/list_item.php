<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_tags
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.framework');

$n			= count($this->items);
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>
<?php if (empty($this->items)) : ?>
	<p> <?php echo JText::_('COM_TAGS_NO_ITEMS'); ?></p>
<?php else : ?>
	<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm">
		<?php if ($this->params->get('filter_field') != 'hide' || $this->params->get('show_pagination_limit')) :?>
		<fieldset class="filters btn-toolbar">
			<?php /* if ($this->params->get('filter_field') != 'hide') :?>
				<div class="btn-group">
					<label class="filter-search-lbl element-invisible" for="filter-search"><span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span><?php echo JText::_('COM_TAGS_FILTER_LABEL').'&#160;'; ?></label>
					<input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="inputbox" onchange="document.adminForm.submit();" title="<?php echo JText::_('COM_TAGS_FILTER_SEARCH_DESC'); ?>" placeholder="<?php echo JText::_('COM_TAGS_FILTER_SEARCH_DESC'); ?>" />
				</div>
			<?php endif; ?>
			<?php if ($this->params->get('show_pagination_limit')) : ?>
				<div class="btn-group pull-right">
					<label for="limit" class="element-invisible">
						<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>
					</label>
					<?php echo $this->pagination->getLimitBox(); ?>
				</div>
			<?php endif; */ ?>
		</fieldset>
		<table class="category table table-striped table-bordered table-hover">
			<?php if ($this->params->get('show_headings')) : ?>
			<thead>
				<tr>
					<th id="categorylist_header_title">
						<?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.core_title', $listDirn, $listOrder); ?>
					</th>
					<?php if ($date = $this->params->get('list_show_date')) : ?>
						<th id="categorylist_header_date">
							<?php if ($date == "created") : ?>
								<?php echo JHtml::_('grid.sort', 'COM_TAGS_'.$date.'_DATE', 'a.core_created_date', $listDirn, $listOrder); ?>
							<?php elseif ($date == "modified") : ?>
								<?php echo JHtml::_('grid.sort', 'COM_TAGS_'.$date.'_DATE', 'a.core_modified_date', $listDirn, $listOrder); ?>
							<?php elseif ($date == "published") : ?>
								<?php echo JHtml::_('grid.sort', 'COM_TAGS_'.$date.'_DATE', 'a.core_publish_up', $listDirn, $listOrder); ?>
							<?php endif; ?>
						</th>
					<?php endif; ?>

				</tr>
			</thead>
			<?php endif; ?>
			<tbody>
				<?php foreach ($this->items as $i => $item) : ?>
					<?php if ($this->items[$i]->core_state == 0) : ?>
					 <tr class="system-unpublished cat-list-row<?php echo $i % 2; ?>">
					<?php else: ?>
					<tr class="cat-list-row<?php echo $i % 2; ?>" >
					<?php endif; ?>
						<td headers="categorylist_header_title" class="list-title">
							<?php if (in_array($item->core_access, $this->user->getAuthorisedViewLevels())) : ?>
								<a href="<?php echo JRoute::_($item->link); ?>">
									<?php echo $this->escape($item->core_title); ?>
								</a>
							<?php endif; ?>
							<?php if ($item->core_state == 0) : ?>
								<span class="list-published label label-warning">
									<?php echo JText::_('JUNPUBLISHED'); ?>
								</span>
							<?php endif; ?>
						</td>
						<?php if ($this->params->get('list_show_date')) : ?>
							<td headers="categorylist_header_date" class="list-date small">
								<?php
								echo JHtml::_(
									'date', $item->displayDate,
									$this->escape($this->params->get('date_format', JText::_('DATE_FORMAT_LC3')))
								); ?>
							</td>
						<?php endif; ?>

					</tr>
				<?php endforeach; ?>
			</tbody>
		</table></div>
	<?php endif; ?>

<?php endif; ?>
<?php // Add pagination links ?>
<?php if (!empty($this->items)) : ?>
	<?php if (($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
	<div class="pagination">

		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
			<p class="counter pull-right">
				<?php echo $this->pagination->getPagesCounter(); ?>
			</p>
		<?php endif; ?>

		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	<?php endif; ?>
</form>
<?php endif; ?>
