<?
defined('C5_EXECUTE') or die("Access Denied.");
$ui = $message->getConversationMessageUserObject();
$class = 'ccm-conversation-message ccm-conversation-message-level' . $message->getConversationMessageLevel();
if ($message->isConversationMessageDeleted()) {
	$class .= ' ccm-conversation-mesage-deleted';
}
$cnvMessageID = $message->cnvMessageID;
?>
<div data-conversation-message-id="<?=$message->getConversationMessageID()?>" data-conversation-message-level="<?=$message->getConversationMessageLevel()?>" class="<?=$class?>">
	<a name="cnvMessage<?=$cnvMessageID?>" />
	<div class="ccm-conversation-message-user">
		<div class="ccm-conversation-avatar"><? print Loader::helper('concrete/avatar')->outputUserAvatar($ui)?></div>
		<div class="ccm-conversation-message-byline"><? if (!is_object($ui)) { ?><?=t('Anonymous')?><? } else { ?><?=$ui->getUserDisplayName()?><? } ?></div>
	</div>
	<div class="ccm-conversation-message-body">
		<?=$message->getConversationMessageBodyOutput()?>
	</div>
	<div class="ccm-conversation-message-controls">
		<div class="message-attachments">
			<?php
			if(count($message->getAttachments($message->cnvMessageID))) {
				foreach ($message->getAttachments($message->cnvMessageID) as $attachment) {
					$file = File::getByID($attachment['fID']);
					if(is_object($file)) { ?>
					<p rel="<?php echo $attachment['cnvMessageAttachmentID'];?>"><a href="<?php echo $file->getDownloadURL() ?>"><?php echo $file->getFileName() ?></a><a rel="<?php echo $attachment['cnvMessageAttachmentID'];?>" class="attachmentDelete" href="#">Delete</a></p>
				<?php }
				}
			} ?>
		</div>
		<? if (!$message->isConversationMessageDeleted()) { ?>
		<ul>
			
			<li class="ccm-conversation-message-admin-control"><a href="#" data-submit="delete-conversation-message" data-conversation-message-id="<?=$message->getConversationMessageID()?>"><?=t('Delete')?></a></li>
			
			<? if ($enablePosting && $displayMode == 'threaded') { ?>
				<li><a href="#" data-toggle="conversation-reply" data-post-parent-id="<?=$message->getConversationMessageID()?>"><?=t('Reply')?></a></li>
			<? } ?>
		</ul>
		<? } ?>

		<?=$message->getConversationMessageDateTimeOutput()?> 
		<?
		$ratingTypes = ConversationRatingType::getList();
		foreach($ratingTypes as $type) { ?>
			<?=$type->outputRatingTypeHTML()?>
		<? } ?>
	</div>
</div>