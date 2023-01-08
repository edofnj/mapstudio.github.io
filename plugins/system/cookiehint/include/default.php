<?PHP
# reDim GmbH - Norbert Bayer
# Plugin: CookieHint
# license GNU/GPL   www.redim.de

// No direct access
defined('JPATH_BASE') or die;

?>
<div id="redim-cookiehint">
	<div class="cookiecontent">
		<?PHP echo JText::_('PLG_SYSTEM_COOKIEHINT_INFO'); ?>
	</div>
	<div class="cookiebuttons">
	<?PHP if(!empty($link)):?>
		<a id="cookiehintinfo" rel="nofollow" href="<?PHP echo $link; ?>" class="btn"><?PHP echo JText::_('PLG_SYSTEM_COOKIEHINT_BTN_INFO'); ?></a>
	<?PHP endif; ?>
		<a id="cookiehintsubmit" rel="nofollow" href="<?PHP echo $linkok; ?>" class="btn"><?PHP echo JText::_('PLG_SYSTEM_COOKIEHINT_BTN_OK'); ?></a>
	<?PHP if($refusal==2):?>
		<?PHP if(!empty($refusalurl)):?>
		<a id="cookiehintsubmitno" rel="nofollow" href="<?PHP echo $refusalurl; ?>" class="btn"><?PHP echo JText::_('PLG_SYSTEM_COOKIEHINT_BTN_NOTOK'); ?></a>
		<?PHP endif; ?>		
	<?PHP elseif($refusal==1):?>
		<a id="cookiehintsubmitno" rel="nofollow" href="<?PHP echo $linknotok; ?>" class="btn"><?PHP echo JText::_('PLG_SYSTEM_COOKIEHINT_BTN_NOTOK'); ?></a>
	<?PHP endif; ?>	
	</div>
	<div class="clr"></div>
</div>	

