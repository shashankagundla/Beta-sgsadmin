// Dashboards
Mousetrap.bind('ctrl+i', function(e) {
    window.location.href = '/dashboard/inspection/';
    return false;
});
Mousetrap.bind('ctrl+e', function(e) {
    window.location.href = '/dashboard/engineering/';
    return false;
});
Mousetrap.bind('ctrl+a', function(e) {
    window.location.href = '/dashboard/atc/';
    return false;
});

//Schedule
Mousetrap.bind('ctrl+m', function(e) {
    window.location.href = '/schedule/main/';
    return false;
});
Mousetrap.bind('ctrl+t', function(e) {
    window.location.href = '/schedule/tia/';
    return false;
});

//Job
Mousetrap.bind('ctrl+j', function(e) {
var sgs = prompt("SGS Number:");
if (sgs != null) {
    window.location.href = '/job/?sgs=' + sgs + '';
    return false;
}
});
