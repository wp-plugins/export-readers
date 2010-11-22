<?php
/**
 * add an admin menu action 'sandbox' by default to all apps
 * @package Library
 * @subpackage SandBoxSandBoxController
 * @copyright DCoda Ltd
 * @author DCoda Ltd
 * @license http://www.gnu.org/licenses/gpl.txt
 * $HeadURL: http://plugins.svn.wordpress.org/wp-contactme/tags/1.3.16.d7v/library/Controllers/SandBoxSandBoxController.php $
 * $LastChangedDate: 2010-10-22 15:27:29 +0100 (Fri, 22 Oct 2010) $
 * $LastChangedRevision: 303057 $
 * $LastChangedBy: dcoda $
 */
class SandBoxSandBoxController extends w6v_Controller_Action_AdminMenu
{
	public function SandBoxAction($content)
	{
		return $content;
	}
}
