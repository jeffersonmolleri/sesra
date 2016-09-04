<addClass select="#validationInvite" value="disabled" />
<html select="#teamList"><![CDATA[
  <?php include "_list_team_revision.php";?>
]]></html>
<eval>
$('#validationInvite').off('click');
$('#validationInvite').on('click',function(e){e.preventDefault();});
</eval>