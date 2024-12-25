/*!
 * @license MIT
 * @name vlitejs
 * @version 7.0.0
 * @copyright 2024 Yoriiis
 */
class e{constructor({player:e,options:t={}}){this.providers=["html5"],this.types=["video"],this.player=e;this.options=Object.assign(Object.assign({},{adTagUrl:"",adsRenderingSettings:{restoreCustomPlaybackStateOnAdBreakComplete:!0,enablePreloading:!0},updateImaSettings:()=>{},adTimeout:5e3,debug:!1}),t),this.playerIsReady=!1,this.sdkIsReady=!1,this.adsLoaded=!1,this.timerAdTimeout=0,this.resumeAd=!1,this.adError=!1,this.adTimeoutReached=!1,this.playIsWaiting=!1,this.isLinearAd=!1,this.playerIsEnded=!1,this.onBigPlayButtonClick=this.onBigPlayButtonClick.bind(this),this.onClickOnAdContainer=this.onClickOnAdContainer.bind(this),this.onPlayerPlay=this.onPlayerPlay.bind(this),this.onVolumeChange=this.onVolumeChange.bind(this),this.onPlayerEnterFullscreen=this.onPlayerEnterFullscreen.bind(this),this.onPlayerExitFullscreen=this.onPlayerExitFullscreen.bind(this),this.onPlayerEnded=this.onPlayerEnded.bind(this),this.onResize=this.onResize.bind(this),this.onAdsManagerLoaded=this.onAdsManagerLoaded.bind(this),this.onAdError=this.onAdError.bind(this),this.onContentPauseRequested=this.onContentPauseRequested.bind(this),this.onContentResumeRequested=this.onContentResumeRequested.bind(this),this.onAdStarted=this.onAdStarted.bind(this),this.onAdPaused=this.onAdPaused.bind(this),this.onAdResumed=this.onAdResumed.bind(this),this.onAdComplete=this.onAdComplete.bind(this),this.onAllAdsCompleted=this.onAllAdsCompleted.bind(this),this.onAdSkipped=this.onAdSkipped.bind(this)}init(){this.loadImaSdk()}loadImaSdk(){const e=document.createElement("script");e.defer=!0,e.type="text/javascript",e.src=`//imasdk.googleapis.com/js/sdkloader/ima3${this.options.debug?"_debug":""}.js`,e.onload=()=>{this.sdkIsReady=!0,this.onPlayerAndSdkReady()},document.getElementsByTagName("body")[0].appendChild(e)}onReady(){this.playerIsReady=!0,this.onPlayerAndSdkReady()}onPlayerAndSdkReady(){this.playerIsReady&&this.sdkIsReady?(this.player.loading(!1),this.render(),this.adContainer=this.player.elements.container.querySelector(".v-ad"),this.addEvents(),this.initAdObjects(),this.requestAds()):this.player.loading(!0)}render(){const e=document.createElement("div");e.classList.add("v-ad"),this.player.elements.container.appendChild(e)}addEvents(){this.player.elements.bigPlay.addEventListener("click",this.onBigPlayButtonClick),this.adContainer.addEventListener("click",this.onClickOnAdContainer),this.player.on("play",this.onPlayerPlay),this.player.on("volumechange",this.onVolumeChange),this.player.on("enterfullscreen",this.onPlayerEnterFullscreen),this.player.on("exitfullscreen",this.onPlayerExitFullscreen),this.player.on("ended",this.onPlayerEnded),window.addEventListener("resize",this.onResize)}onBigPlayButtonClick(){this.resumeAd&&(this.resumeAd=!1,this.adsManager.resume())}onClickOnAdContainer(){this.isLinearAd||this.player.elements.playPause.dispatchEvent(new Event("click",{bubbles:!0}))}initAdObjects(){this.adsLoaded=!1,window.google.ima.settings.setDisableCustomPlaybackForIOS10Plus(this.player.options.playsinline),this.options.updateImaSettings instanceof Function&&this.options.updateImaSettings(window.google.ima.settings),this.adDisplayContainer=new window.google.ima.AdDisplayContainer(this.adContainer,this.player.media),this.adsLoader=new window.google.ima.AdsLoader(this.adDisplayContainer),this.adsLoader.addEventListener(window.google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED,this.onAdsManagerLoaded,!1),this.adsLoader.addEventListener(window.google.ima.AdErrorEvent.Type.AD_ERROR,this.onAdError,!1),this.player.dispatchEvent("adsloader",{adsLoader:this.adsLoader})}requestAds(){const e=new window.google.ima.AdsRequest;e.adTagUrl=this.options.adTagUrl,e.linearAdSlotWidth=this.player.media.clientWidth,e.linearAdSlotHeight=this.player.media.clientHeight,e.nonLinearAdSlotWidth=this.player.media.clientWidth,e.nonLinearAdSlotHeight=this.player.media.clientHeight/3,this.adsLoader.requestAds(e),this.player.dispatchEvent("adsrequest",{adsRequest:e})}onAdsManagerLoaded(e){const t=Object.assign(Object.assign(Object.assign({},new window.google.ima.AdsRenderingSettings),{uiElements:[window.google.ima.UiElements.AD_ATTRIBUTION,window.google.ima.UiElements.COUNTDOWN]}),this.options.adsRenderingSettings);this.adsManager=e.getAdsManager(this.player.media,t),this.adsManager.addEventListener(window.google.ima.AdErrorEvent.Type.AD_ERROR,this.onAdError),this.adsManager.addEventListener(window.google.ima.AdEvent.Type.CONTENT_PAUSE_REQUESTED,this.onContentPauseRequested),this.adsManager.addEventListener(window.google.ima.AdEvent.Type.CONTENT_RESUME_REQUESTED,this.onContentResumeRequested),this.adsManager.addEventListener(window.google.ima.AdEvent.Type.STARTED,this.onAdStarted),this.adsManager.addEventListener(window.google.ima.AdEvent.Type.PAUSED,this.onAdPaused),this.adsManager.addEventListener(window.google.ima.AdEvent.Type.RESUMED,this.onAdResumed),this.adsManager.addEventListener(window.google.ima.AdEvent.Type.COMPLETE,this.onAdComplete),this.adsManager.addEventListener(window.google.ima.AdEvent.Type.ALL_ADS_COMPLETED,this.onAllAdsCompleted),this.adsManager.addEventListener(window.google.ima.AdEvent.Type.SKIPPED,this.onAdSkipped),this.cuePoints=this.adsManager.getCuePoints(),Array.isArray(this.cuePoints)&&this.cuePoints.length&&this.player.elements.progressBar&&this.addCuePoints(),this.player.dispatchEvent("adsmanager",{adsManager:this.adsManager}),this.playIsWaiting&&!this.adTimeoutReached&&(clearTimeout(this.timerAdTimeout),this.onPlayerPlay())}onContentPauseRequested(){this.adContainer.classList.add("v-active"),!1===this.player.isPaused&&this.player.pause()}onContentResumeRequested(){this.clean(),this.adContainer.classList.remove("v-active"),!this.playerIsEnded&&this.player.play()}onAdStarted(e){this.player.loading(!1),this.currentAd=e.getAd(),this.isLinearAd=this.currentAd.isLinear(),this.isLinearAd?this.player.isLinearAd=!0:this.adContainer.classList.add("v-active"),this.player.elements.outerContainer.classList[this.isLinearAd?"remove":"add"]("v-adNonLinear"),this.player.elements.outerContainer.classList.add("v-adPlaying"),this.player.elements.outerContainer.classList.remove("v-adPaused")}onAdPaused(){this.resumeAd=!0,this.player.elements.outerContainer.classList.add("v-adPaused"),this.player.elements.outerContainer.classList.remove("v-adPlaying")}onAdResumed(){this.player.elements.outerContainer.classList.add("v-adPlaying"),this.player.elements.outerContainer.classList.remove("v-adPaused")}onAdComplete(){}onAllAdsCompleted(){this.clean(),!this.playerIsEnded&&this.player.play()}onAdSkipped(){this.clean(),this.player.play()}onAdError(e){this.adError=!0,clearTimeout(this.timerAdTimeout);try{const t=e.getError();if(null==t?void 0:t.j){const{type:e,errorCode:i,errorMessage:s}=t.j;console.warn(`${e} ${i}: ${s}`)}}catch(t){console.warn("onAdError",e)}this.destroy(),(this.player.options.autoplay||this.playIsWaiting)&&this.player.play()}addCuePoints(){const e=document.createElement("div");e.classList.add("v-cuePoints"),this.player.getDuration().then((t=>{this.cuePoints.filter((e=>0!==e&&-1!==e&&e<t)).forEach((i=>{const s=100*i/t,a=document.createElement("span");a.classList.add("v-cuePoint"),a.style.left=`${s}%`,e.appendChild(a)})),this.player.elements.controlBar.appendChild(e)}))}onPlayerPlay(){if(this.playerIsEnded=!1,!(this.adsLoaded||this.adError||this.adTimeoutReached))if(this.adDisplayContainer&&this.adsManager){this.adsLoaded=!0,this.adDisplayContainer.initialize();try{this.adsManager.init(this.player.media.clientWidth,this.player.media.clientHeight,window.google.ima.ViewMode.NORMAL),this.player.getVolume().then((e=>{this.adsManager.setVolume(e),this.adsManager.start()}))}catch(e){this.onAdError(e)}}else this.waitingAd()}waitingAd(){this.playIsWaiting=!0,this.player.pause(),window.setTimeout((()=>this.player.loading(!0)),0),this.timerAdTimeout=window.setTimeout((()=>{this.onAdTimeoutReached()}),this.options.adTimeout)}onAdTimeoutReached(){this.adTimeoutReached=!0,this.player.loading(!1),this.onAdError({errorMessage:"Timeout is reached"}),this.playIsWaiting=!1}onVolumeChange(){this.player.getVolume().then((e=>this.adsManager.setVolume(e)))}onPlayerEnterFullscreen(){this.adsManager&&this.adsManager.resize(window.screen.width,window.screen.height,window.google.ima.ViewMode.FULLSCREEN)}onPlayerEnded(){this.playerIsEnded=!0,this.adsLoader.contentComplete()}onPlayerExitFullscreen(){this.adsManager&&this.adsManager.resize(this.player.media.clientWidth,this.player.media.clientHeight,window.google.ima.ViewMode.NORMAL)}onResize(){var e;null===(e=this.adsManager)||void 0===e||e.resize(this.player.media.clientWidth,this.player.media.clientHeight,window.google.ima.ViewMode.NORMAL)}removeEventListener(){this.player.elements.bigPlay.removeEventListener("click",this.onBigPlayButtonClick),this.adContainer.removeEventListener("click",this.onClickOnAdContainer),this.player.off("play",this.onPlayerPlay),this.player.off("volumechange",this.onVolumeChange),this.player.off("enterfullscreen",this.onPlayerEnterFullscreen),this.player.off("exitfullscreen",this.onPlayerExitFullscreen),this.player.off("ended",this.onPlayerEnded),window.removeEventListener("resize",this.onResize)}clean(){this.player.isLinearAd=!1,this.adContainer.classList.remove("v-active","v-adNonLinear"),this.player.elements.outerContainer.classList.remove("v-adPlaying","v-adPaused")}destroy(){this.clean(),this.removeEventListener(),this.adsManager&&(this.adsManager.destroy(),this.adsManager=null),this.adDisplayContainer&&(this.adDisplayContainer.destroy(),this.adDisplayContainer=null),this.adsLoader&&(this.adsLoader.destroy(),this.adsLoader=null)}}export{e as default};