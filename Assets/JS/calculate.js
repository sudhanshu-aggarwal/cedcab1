$("#calculate").click((e) => {
  e.preventDefault();
  if ($("#pickup").val() == null) {
    $("#labelPickup").text("Please Select Pickup Location");
    $("#labelPickup").css("color", "#870900");
  } else if ($("#drop").val() == null) {
    $("#labelPickup").text("Select Pickup Location");
    $("#labelPickup").css("color", "black");
    $("#labelDrop").text("Please Select Drop Location");
    $("#labelDrop").css("color", "#870900");
  } else if ($("#cabtype").val() == null) {
    $("#labelPickup").text("Select Pickup Location");
    $("#labelPickup").css("color", "black");
    $("#labelDrop").text("Select Drop Location");
    $("#labelDrop").css("color", "black");
    $("#labelCabtype").text("Please Select Cab Type");
    $("#labelCabtype").css("color", "#870900");
  } else {
    $.ajax({
      url: "/cedcab/helper.php",
      method: "post",
      data: {
        pickup: $("#pickup").val(),
        drop: $("#drop").val(),
        cabtype: $("#cabtype").val(),
        luggage: $("#luggage").val(),
        action: "calculateFare",
      },
      success: (res) => {
        let response = JSON.parse(res);
        $("#labelPickup").text("Select Pickup Location");
        $("#labelPickup").css("color", "black");
        $("#labelDrop").text("Select Drop Location");
        $("#labelDrop").css("color", "black");
        $("#labelCabtype").text("Select Cab Type");
        $("#labelCabtype").css("color", "black");
        $(".modal-body").html(
          'Pickup Location: <label id="pickupPoint">' +
            response[0] +
            '</label><br>Drop Location: <label id="dropPoint">' +
            response[1] +
            '</label><br>Luggage: <label id="totalLuggage">' +
            response[4] +
            '</label><br>Cab Type: <label id="typeofCab">' +
            response[5] +
            '</label><br>Total Distance: <label id="totalDistance">' +
            response[2] +
            ' </label> KM<br>Total Fare: Rs <label id="totalFare">' +
            response[3] +
            "</label>/-"
        );
        $("#exampleModal").modal("show");
      },
    });
  }
});
