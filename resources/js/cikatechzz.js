/*********************************************************************
 * Raymond Ginting 6 April 2021 10:34 pm
 * ini untuk format uang
 ********************************************************************/
function formatRibuan(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function bknFormatRibuan(x) {
    return x.replace(/[,]/g, "");
}
function onlyNumber(n) {
    return n.replace(/\D[.]/g, '');
}
function formatUang(x) {
    $(document).on("keyup", x, function () {
        var jumlah = bknFormatRibuan($(this).val());
        jumlah = onlyNumber(jumlah);

        jumlah = parseFloat(jumlah);
        if (isNaN(jumlah)) jumlah = '';

        $(this).val(formatRibuan(jumlah));
    });
}