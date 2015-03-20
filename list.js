$(function () {
  $('#form-entries td input[type=checkbox]').parent('td').remove();
  $('#form-entries tr.line').each(function () {
    var $expender = $('<td class="expander"></td>');
    $(this).prepend($expender);
    $expender.prepend($(this).find('td input[type=image]'));
  });
  $('#form-entries tr:not(.line) th:first').attr('colspan', 3);
  $("#form-entries tbody").sortable({
    cursor: 'move',
    stop: function (event, ui) {
      $("#form-entries tr td input.position").each(function (i) {
        $(this).val(i + 1);
      });
    }
  });
  $("#form-entries tr").hover(function () {
    $(this).css({'cursor': 'move'});
  }, function () {
    $(this).css({'cursor': 'auto'});
  });
  $("#form-entries tr td input.position").hide();
  $("#form-entries tr td.handle").addClass('handler');
  $("form input[type=submit]").click(function () {
    $("input[type=submit]", $(this).parents("form")).removeAttr("clicked");
    $(this).attr("clicked", "true");
  });
});