$(document).ready(function() {
    // fill clendar
    Calendar.fill();
    
    // recalculate
    Calendar.recalculate();
    
    // attach event for changing mileage
    $('[name^="dist"]').keyup(function() {
        Calendar.onChange(this);
        //Calendar.save(this);
    });
    $('[name^="dist"]').change(function() {
        Calendar.mileageObject = $(this);
        Calendar._save();
    });
});


Calendar = {
    timerid : null,
    mileageObject : null,
    
    'onChange' : function(obj) {
        obj = $(obj);
        name = obj.attr('name');
        if (isNaN(obj.val())) {
            obj.val('');
            return;
        }
        var myregexp = /\[(\d+)\]\[(\d+)\]/;
        var match = myregexp.exec(obj.attr('name'));
        this.recalculate();
    },
    
    'recalculate' : function() {
        this.recalculateMonth();
        this.recalculateYear();
    },
    
    'recalculateMonth' : function() {
        self = this;
        for (i = 1; i <=12; i++) {
            var sum = 0.0;
            $('[name^="dist['+ i +']"]').each(function() {
                if (this.value != '' && !isNaN(this.value)) {
                    sum += parseFloat(this.value);
                }
            });
            $('[name="month['+ i +']"]').val(sum);
        }
    },
    
    'recalculateYear' : function() {
        self = this;
        var sum = 0.0;
        $('[name^="month"]').each(function() {
            if (this.value != '' && !isNaN(this.value)) {
                sum += parseFloat(this.value);
            }
        });
        $('#year-dist').html(sum + ' км');
    },
    
    'fill' : function() {
        self = this;
        for (var month in CONST.mileageData) {
            var days = CONST.mileageData[month];
            for (day in days) {
                var mileage = days[day];
                $('[name="dist['+ month + '][' + day + ']"]').val(mileage);
            }
        }
        self.recalculate();
    },
    
    'save' : function (obj) {
        self = this;
        self.mileageObject = $(obj);
        if (self.timerid !== null) {
            clearTimeout(self.timerid);
        }
        self.timerid = window.setTimeout(function() {
            self._save();
        }, 4000);
    },
    
    '_save' : function() {
        self = this;
        
        Loading.show();        
        $.ajax({
            'url' : '/site/saveMileage',
            'dataType' : 'json',
            'type' : 'POST',
            'data' : {
                'name'    : self.mileageObject.attr('name'),
                'mileage' : self.mileageObject.val()
            }
        }).done(function(res) {
            Loading.hide();
        });
        
    }
    
}