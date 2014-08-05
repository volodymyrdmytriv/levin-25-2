Slider = Class.refactor(Slider,
{    
    attach: function(){
        this.element.addEvent('touchstart', this.clickedElement);
        if (this.options.wheel) this.element.addEvent('mousewheel', this.scrolledElement);
        this.drag.attach();
        return this;
    },

    detach: function(){
        this.element.removeEvent('touchstart', this.clickedElement)
            .removeEvent('mousewheel', this.scrolledElement);
        this.drag.detach();
        return this;
    }
});
