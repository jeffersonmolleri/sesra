function createPasswordFields(el)
{
  $('#password_check').val(1);
  $(el).remove();
  $("#password_label .controls").append('<input name="sf_guard_user[password]" id="sf_guard_user_password" type="password" value="" class="input-large" autocomplete="off" required="required" />');
  $("#password_again_label .controls").append('<input name="sf_guard_user[password_again]" id="sf_guard_user_password_again" type="password" value="" class="input-large" autocomplete="off" required="required" />');
  $("#password_label").show();
  $("#password_again_label").show();
}

$(document).ready(function () {
  $("#pwd").click(function (e) {
    e.preventDefault();
    createPasswordFields(this);
  });
});
