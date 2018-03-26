$(document).ready(function () {
    // common listeners
    $(document)
        .on('click', '.container', function (e) {
            $(this).find('.selected').removeClass('selected');
        })
        .on('click', '.drag', function (e) {
            $(this).addClass('selected');
            e.stopPropagation();
        });
        
    // with snap
    $('#mutilDrag .drag').draggable({
        containment: "parent",
        multiple: true,
        selected: '#mutilDrag .selected',
        snap: '#mutilDrag .drag',
        beforeStart: function () {
            var $this = $(this);
            if (!$this.hasClass('selected')) {
                $this.siblings('.selected').removeClass('selected');
                $this.addClass('selected');
            }
        }
    });
});