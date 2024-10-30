jQuery(function($) {
    $(".burc_container button[type=submit]").click(function(e) {
        e.preventDefault();
        var $burc = $(this).parents(".burc_container").find("[name=selected_burc]").find("option:selected").index();
        var $zaman = $(this).parents(".burc_container").find("[name=selected_zaman]").find("option:selected").index();
        var $res = computeForm($burc, $zaman);
        $(this).parents(".burc_container").find("[name=selected_result]").val($res);
        return false;
    });
    function computeForm(burc, zaman) {
            var idxnum = rtnIndex(burc, zaman);
            var sendArray = new makeObject();
            sendArray[0] = "Kova";
            sendArray[1] = "Boğa";
            sendArray[2] = "İkizler";
            sendArray[3] = "Yengeç";
            sendArray[4] = "Aslan";
            sendArray[5] = "Başak";
            sendArray[6] = "Terazi";
            sendArray[7] = "Akrep";
            sendArray[8] = "Yay";
            sendArray[9] = "Oğlak";
            sendArray[10] = "Kova";
            sendArray[11] = "Balık";
            return sendArray[idxnum];
        }
        function makeObject() {
            return this;
        }
        function rtnIndex(send, zamanrange) {
            var idxnum;
            if (send == 0) { idxnum = zamanrange; return idxnum; }
            if (send == 1) { idxnum = (zamanrange + 1) % 12; return idxnum; }
            if (send == 2) { idxnum = (zamanrange + 2) % 12; return idxnum; }
            if (send == 3) { idxnum = (zamanrange + 3) % 12; return idxnum; }
            if (send == 4) { idxnum = (zamanrange + 4) % 12; return idxnum; }
            if (send == 5) { idxnum = (zamanrange + 5) % 12; return idxnum; }
            if (send == 6) { idxnum = (zamanrange + 6) % 12; return idxnum; }
            if (send == 7) { idxnum = (zamanrange + 7) % 12; return idxnum; }
            if (send == 8) { idxnum = (zamanrange + 8) % 12; return idxnum; }
            if (send == 9) { idxnum = (zamanrange + 9) % 12; return idxnum; }
            if (send == 10) { idxnum = (zamanrange + 10) % 12; return idxnum; }
            if (send == 11) { idxnum = (zamanrange + 11) % 12; return idxnum; }
        }
});