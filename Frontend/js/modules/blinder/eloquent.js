export default class eloquent  {

    static lang = 'pt-BR';

    static loadRecognition(){
        var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
        return new SpeechRecognition();
    }

    static startListenning(callback){
        eloquent.recognition = eloquent.loadRecognition();
        eloquent.recognition.lang = eloquent.lang;
        eloquent.recognition.interimResults = true;
        eloquent.recognition.continuous = true;
        eloquent.recognition.maxAlternatives = 1;
        eloquent.callback = callback;
        eloquent.recognition.start();
        return eloquent;
    }

    static stopListenning(){
        if(eloquent.callback != undefined){
            eloquent.recognition.onresult = function(event){
                let text = event.results[0][0].transcript;
                eloquent.callback(text, event);
            };
        }
        eloquent.recognition.stop();
        return eloquent;
    }

    static speak(text){
        let speaking = new SpeechSynthesisUtterance(text);
        speaking.lang = eloquent.lang;
        speechSynthesis.speak(speaking);
        return eloquent;
    }
}