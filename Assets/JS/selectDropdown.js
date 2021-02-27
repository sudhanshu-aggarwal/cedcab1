let selected = [];
$("#cabtype").change(() => {
  if ($("#cabtype").val() == "CedMicro") {
    $("#luggage").val("");
    $("#luggage").prop("disabled", true);
    $("#luggage").attr("placeholder", "Luggage not allowed");
  } else {
    $("#luggage").prop("disabled", false);
    $("#luggage").attr("placeholder", "Luggage in KG");
  }
});

$("#pickup").change(() => {
  $("#drop")
    .children('option[value="' + selected[0] + '"]')
    .show();
  selected[0] = $("#pickup").val();
  $("#drop")
    .children('option[value="' + selected[0] + '"]')
    .hide();
});

$("#drop").change(() => {
  $("#pickup")
    .children('option[value="' + selected[1] + '"]')
    .show();
  selected[1] = $("#drop").val();
  $("#pickup")
    .children('option[value="' + selected[1] + '"]')
    .hide();
});
