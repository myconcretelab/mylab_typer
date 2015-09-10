   debug = true;
// the semi-colon before the function invocation is a safety
// net against concatenated scripts and/or other plugins
// that are not closed properly.
;(function ( $, window, document, undefined ) {

    var plugin;
    var el;
    var headline;

    // Create the defaults once
    var pluginName = "MyLabTyper",
        defaults = {
            //set animation timing
            animationDelay: 2500,
            //loading bar effect
            barAnimationDelay: 3800,
            barWaiting: 3800 - 3000, //3000 is the duration of the transition on the loading bar - set in the scss/css file
            //letters effect
            lettersDelay: 50,
            //type effect
            typeLettersDelay: 150,
            selectionDuration: 500,
            typeAnimationDelay: 500 + 800,
            //clip effect 
            revealDuration: 600,
            revealAnimationDelay: 1500        
        };

    // The actual plugin constructor
    function Plugin ( element, options ) {

        plugin = this;
        el = $(element);
      
        this.options = $.extend( {}, defaults, options) ;

        this._defaults = defaults;
        this._name = pluginName;

        this.init();
    }

    Plugin.prototype = {

        init: function() {
 
            this.headline = el.find('.cd-headline');
            this.words = el.find('.cd-headline b');
            this.wordWrapper = this.headline.find('.cd-words-wrapper');

            //initialise headline animation                   
            if(this.headline.hasClass('type')) this.initSingleLetterAnimation();
            this.initWordsAnimation();            
        },

        initSingleLetterAnimation: function() {
            this.words.each(function(){
                var word = $(this),
                    strongTagOpen = word.indexOf('<strong>'),
                    strongTagClose = word.indexOf('</strong>'),
                    selected = word.hasClass('is-visible');
                // This is to remove <strong>, not very compact but works
                if (strongTagOpen > -1) {
                    word.replace('<strong>','');
                    word.replace('</strong>','');                    
                }
                var letters = word.text().split('');
                    
                for (i in letters) {
                    l("i : " + i + " / strong : " +  strongTagOpen);
                    if(word.parents('.wrap-em').length > 0) letters[i] = '<em>' + letters[i] + '</em>';
                    letters[i] = (selected) ? '<i class="in">' + letters[i] + '</i>': '<i>' + letters[i] + '</i>';
                }
                var newLetters = letters.join('');
                word.html(newLetters);
            });
        },

        initWordsAnimation: function() {

          var duration = this.options.animationDelay;

          if (this.headline.hasClass('clip')) {
            var newWidth = this.wordWrapper.width() + 10
            this.wordWrapper.css('width', newWidth);
          } else if (!this.headline.hasClass('type') ) {
            //assign to .cd-words-wrapper the width of its longest word
            var width = 0;
            this.words.each(function(){
              var wordWidth = $(this).width();
              if (wordWidth > width) width = wordWidth;
              
            });
            this.wordWrapper.css('width', width);
          };

          // the 'this' into setTimeout is Document
          // So we nee to create a reference
          // Et ceci et la plus grande incompréhesion en JAvascript ds ma petite tete :
          // Les lignes suivantes fonctionnent, mais si j'envoie un this en argument, 
          // Au premier rappel celui ci devient 'undefined' alors que l'appel à la foinction et a des 
          // variables continue à fonctionner !!
          setTimeout($.proxy(function() {
            this.hideWord(this.headline.find('.is-visible').eq(0) );
          },this), duration);
          
        },
      
        hideWord: function($word) {

            var nextWord = this.takeNext($word),
                headline = $word.parents('.cd-headline');

            if(headline.hasClass('type')) {
                var parentSpan = this.wordWrapper;
                this.wordWrapper.addClass('selected').removeClass('waiting'); 
                setTimeout(function(){ 
                    parentSpan.removeClass('selected'); 
                    $word.removeClass('is-visible').addClass('is-hidden').children('i').removeClass('in').addClass('out');
                }, this.options.selectionDuration);
                setTimeout(function(){ plugin.showWord(nextWord, plugin.options.typeLettersDelay) }, this.options.typeAnimationDelay);
            
            } else if(headline.hasClass('letters')) {
                var bool = ($word.children('i').length >= nextWord.children('i').length) ? true : false;
                this.hideLetter($word.find('i').eq(0), $word, bool, this.options.lettersDelay);
                this.showLetter(nextWord.find('i').eq(0), nextWord, bool, this.options.lettersDelay);

            }  else if(headline.hasClass('clip')) {
                $word.parents('.cd-words-wrapper').animate({ width : '2px' }, plugin.options.revealDuration, function(){
                    plugin.switchWord($word, nextWord);
                    plugin.showWord(nextWord);
                });

            } else if (headline.hasClass('loading-bar')){
                $word.parents('.cd-words-wrapper').removeClass('is-loading');
                this.switchWord($word, nextWord);
                setTimeout(function(){ plugin.hideWord(nextWord) }, this.options.barAnimationDelay);
                setTimeout(function(){ $word.parents('.cd-words-wrapper').addClass('is-loading') }, plugin.options.barWaiting);

            } else {
                this.switchWord($word, nextWord);
                setTimeout(function(){ plugin.hideWord(nextWord) }, this.options.animationDelay);
            }
  
        },

        showWord: function($word, $duration) {
            if($word.parents('.cd-headline').hasClass('type')) {
                this.showLetter($word.find('i').eq(0), $word, false, $duration);
                $word.addClass('is-visible').removeClass('is-hidden');

            }  else if($word.parents('.cd-headline').hasClass('clip')) {
                $word.parents('.cd-words-wrapper').animate({ 'width' : $word.width() + 10 }, plugin.options.revealDuration, function() { 
                    setTimeout(function(){ plugin.hideWord($word) }, plugin.options.revealAnimationDelay); 
                });
            }
        },

        hideLetter: function($letter, $word, $bool, $duration) {
            $letter.removeClass('in').addClass('out');
          
            if(!$letter.is(':last-child')) {
                setTimeout(function(){ plugin.hideLetter($letter.next(), $word, $bool, $duration); }, $duration);  
            } else if($bool) { 
                setTimeout(function(){ plugin.hideWord(plugin.takeNext($word)) }, plugin.options.animationDelay);
            }

            if($letter.is(':last-child') && $('html').hasClass('no-csstransitions')) {
                var nextWord = this.takeNext($word);
                this.switchWord($word, nextWord);
            } 
        },

        showLetter: function($letter, $word, $bool, $duration) {
            $letter.addClass('in').removeClass('out');
            
            if(!$letter.is(':last-child')) { 
                setTimeout(function(){ plugin.showLetter($letter.next(), $word, $bool, $duration); }, $duration); 
            } else { 
                if($word.parents('.cd-headline').hasClass('type')) { setTimeout(function(){ $word.parents('.cd-words-wrapper').addClass('waiting'); }, 200);}
                if(!$bool) { setTimeout(function(){ plugin.hideWord($word) }, plugin.options.animationDelay) }
            }
        },

        takeNext: function($word) {
            return (!$word.is(':last-child')) ? $word.next() : $word.parent().children().eq(0);
        },

        takePrev: function($word) {
            return (!$word.is(':first-child')) ? $word.prev() : $word.parent().children().last();
        },

        switchWord: function($oldWord, $newWord) {
            $oldWord.removeClass('is-visible').addClass('is-hidden');
            $newWord.removeClass('is-hidden').addClass('is-visible');
        }        
    }

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
         return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName,
                new Plugin( this, options ));
            }
        });
    };

})( jQuery, window, document );
           

function l() {
    if (debug == true) {
        for (var i = 0; i < arguments.length; i++) {
            if (window.CP.shouldStopExecution(1)) {
                break;
            }
            console.log(arguments[i]);
        }
        window.CP.exitedLoop(1);
    }
}