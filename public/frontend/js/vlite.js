/**
 * @license MIT
 * @name vLitejs
 * @version 1.1.0
 * @author: Yoriiis aka Joris DANIEL <joris.daniel@gmail.com>
 * @description: vLite.js is a fast and lightweight Javascript library to customize and skin native HTML5 video and Youtube video in Javascript native with a default skin
 * {@link https://vlite.bitbucket.io}
 * @copyright 2018 Joris DANIEL <https://vlite.bitbucket.io>
 **/

!(function (e) {
    function t(r) {
        if (n[r]) return n[r].exports;
        var o = (n[r] = { i: r, l: !1, exports: {} });
        return e[r].call(o.exports, o, o.exports, t), (o.l = !0), o.exports;
    }
    var n = {};
    (t.m = e),
        (t.c = n),
        (t.d = function (e, n, r) {
            t.o(e, n) ||
                Object.defineProperty(e, n, {
                    configurable: !1,
                    enumerable: !0,
                    get: r,
                });
        }),
        (t.n = function (e) {
            var n =
                e && e.__esModule
                    ? function () {
                          return e.default;
                      }
                    : function () {
                          return e;
                      };
            return t.d(n, "a", n), n;
        }),
        (t.o = function (e, t) {
            return Object.prototype.hasOwnProperty.call(e, t);
        }),
        (t.p = "/js//"),
        t((t.s = 1));
})([
    function (e, t, n) {
        "use strict";
        function r(e, t) {
            if (!(e instanceof t))
                throw new TypeError("Cannot call a class as a function");
        }
        Object.defineProperty(t, "__esModule", { value: !0 });
        var o = (function () {
                function e(e, t) {
                    for (var n = 0; n < t.length; n++) {
                        var r = t[n];
                        (r.enumerable = r.enumerable || !1),
                            (r.configurable = !0),
                            "value" in r && (r.writable = !0),
                            Object.defineProperty(e, r.key, r);
                    }
                }
                return function (t, n, r) {
                    return n && e(t.prototype, n), r && e(t, r), t;
                };
            })(),
            i = (function () {
                function e(t) {
                    var n = t.selector,
                        o = t.options,
                        i = t.callback;
                    r(this, e),
                        (this.callback = i),
                        (this.isFullScreen = !1),
                        (this.player = n),
                        (this.touchSupport = !!(
                            "ontouchstart" in window ||
                            (window.DocumentTouch &&
                                document instanceof DocumentTouch)
                        )),
                        (this.skinDisabled = !1);
                    var a = {},
                        s = {
                            autoplay: !1,
                            controls: !0,
                            playPause: !0,
                            timeline: !0,
                            time: !0,
                            volume: !0,
                            fullscreen: !0,
                            poster: null,
                            bigPlay: !0,
                            nativeControlsForTouch: !1,
                        };
                    (a = this.player.hasAttribute("data-options")
                        ? JSON.parse(this.player.getAttribute("data-options"))
                        : o),
                        (this.options = this.constructor.extend(!0, s, a)),
                        this.touchSupport &&
                            this.options.nativeControlsForTouch &&
                            ((this.skinDisabled = !0),
                            this.player.setAttribute("controls", "controls"),
                            (this.options.controls = !1)),
                        (this.supportFullScreen =
                            this.constructor.checkSupportFullScreen()),
                        this.buildPlayer(),
                        this.bindEvents();
                }
                return (
                    o(
                        e,
                        [
                            {
                                key: "buildPlayer",
                                value: function () {
                                    var e = document.createElement("div");
                                    e.setAttribute(
                                        "class",
                                        "wrapper-vlite first-start paused loading"
                                    ),
                                        this.player.parentNode.insertBefore(
                                            e,
                                            this.player
                                        ),
                                        e.appendChild(this.player),
                                        (this.wrapperPlayer =
                                            this.player.parentNode),
                                        this.player.classList.add(
                                            "toggle-play-pause-js"
                                        ),
                                        this.skinDisabled &&
                                            this.wrapperPlayer.classList.add(
                                                "force-controls"
                                            );
                                    var t =
                                            null !== this.options.poster
                                                ? "background-image: url(" +
                                                  this.options.poster +
                                                  ");"
                                                : "",
                                        n =
                                            '<div class="wrapper-loader">\n                                <div class="loader">\n                                    <div class="loader-bounce-1"></div>\n                                    <div class="loader-bounce-2"></div>\n                                    <div class="loader-bounce-3"></div>\n                                </div>\n                            </div>\n                            <div class="poster toggle-play-pause-js active" style="' +
                                            t +
                                            '"></div>\n                            ' +
                                            (this.options.bigPlay
                                                ? '<div class="big-play-button toggle-play-pause-js">\n                                     <span class="player-icon icon-play2"></span>\n                                </div>'
                                                : "") +
                                            "\n                            " +
                                            (this.options.controls
                                                ? '<div class="control-bar">\n                                    ' +
                                                  (this.options.timeline
                                                      ? '<div class="progress-bar">\n                                            <div class="progress-seek"></div>\n                                            <input type="range" class="progress-input" min="0" max="100" step="0.01" value="0" orient="horizontal" />\n                                        </div>'
                                                      : "") +
                                                  '\n                                    <div class="control-bar-inner">\n                                        ' +
                                                  (this.options.playPause
                                                      ? '<div class="play-pause-button toggle-play-pause-js">\n                                                <span class="player-icon icon-play3"></span>\n                                                <span class="player-icon icon-pause2"></span>\n                                            </div>'
                                                      : "") +
                                                  "\n                                        " +
                                                  (this.options.time
                                                      ? '<div class="time">\n                                                <span class="current-time">00:00</span>&nbsp;/&nbsp;<span class="duration"></span>\n                                            </div>'
                                                      : "") +
                                                  "\n                                        " +
                                                  (this.options.volume
                                                      ? '<div class="volume">\n                                                <span class="player-icon icon-volume-high"></span>\n                                                <span class="player-icon icon-volume-mute"></span>\n                                            </div>'
                                                      : "") +
                                                  "\n                                        " +
                                                  (this.options.fullscreen
                                                      ? '<div class="fullscreen">\n                                                <span class="player-icon icon-fullscreen"></span>\n                                                <span class="player-icon icon-shrink"></span>\n                                            </div>'
                                                      : "") +
                                                  "\n                                    </div>\n                                </div>"
                                                : "");
                                    e.insertAdjacentHTML("beforeend", n);
                                },
                            },
                            {
                                key: "bindEvents",
                                value: function () {
                                    var e = this;
                                    this.options.controls &&
                                        this.options.timeline &&
                                        ((this.onChangeProgressBar = function (
                                            t
                                        ) {
                                            e.onProgressChanged(t);
                                        }),
                                        this.wrapperPlayer
                                            .querySelector(".progress-input")
                                            .addEventListener(
                                                "change",
                                                this.onChangeProgressBar,
                                                !1
                                            )),
                                        (this.onClickTogglePlayPause =
                                            function (t) {
                                                t.preventDefault(),
                                                    e.togglePlayPause();
                                            }),
                                        [].forEach.call(
                                            this.wrapperPlayer.querySelectorAll(
                                                ".toggle-play-pause-js"
                                            ),
                                            function (t) {
                                                t.addEventListener(
                                                    "click",
                                                    e.onClickTogglePlayPause,
                                                    !1
                                                );
                                            }
                                        ),
                                        this.options.controls &&
                                            this.options.volume &&
                                            ((this.onCLickToggleVolume =
                                                function (t) {
                                                    t.preventDefault(),
                                                        e.toggleVolume();
                                                }),
                                            this.wrapperPlayer
                                                .querySelector(".volume")
                                                .addEventListener(
                                                    "click",
                                                    this.onCLickToggleVolume,
                                                    !1
                                                )),
                                        this.options.controls &&
                                            this.options.fullscreen &&
                                            ((this.onClickToggleFullscreen =
                                                function (t) {
                                                    t.preventDefault(),
                                                        e.toggleFullscreen();
                                                }),
                                            this.wrapperPlayer
                                                .querySelector(".fullscreen")
                                                .addEventListener(
                                                    "click",
                                                    this
                                                        .onClickToggleFullscreen,
                                                    !1
                                                )),
                                        (this.onChangeFullScreen = function (
                                            t
                                        ) {
                                            !document[
                                                e.supportFullScreen.isFullScreen
                                            ] &&
                                                e.isFullScreen &&
                                                e.exitFullscreen(t.target);
                                        }),
                                        window.addEventListener(
                                            this.supportFullScreen.changeEvent,
                                            this.onChangeFullScreen,
                                            !1
                                        );
                                },
                            },
                            {
                                key: "playerIsReady",
                                value: function () {
                                    this.loading(!1),
                                        "function" == typeof this.callback &&
                                            this.callback(this),
                                        this.options.autoplay &&
                                            this.togglePlayPause();
                                },
                            },
                            {
                                key: "loading",
                                value: function (e) {
                                    e
                                        ? this.wrapperPlayer.classList.add(
                                              "loading"
                                          )
                                        : this.wrapperPlayer.classList.remove(
                                              "loading"
                                          );
                                },
                            },
                            {
                                key: "updateDuration",
                                value: function () {
                                    this.wrapperPlayer.querySelector(
                                        ".duration"
                                    ).innerHTML =
                                        this.constructor.formatVideoTime(
                                            this.getDuration()
                                        );
                                },
                            },
                            {
                                key: "onVideoEnded",
                                value: function () {
                                    this.wrapperPlayer.classList.replace(
                                        "playing",
                                        "paused"
                                    ),
                                        this.wrapperPlayer.classList.add(
                                            "first-start"
                                        ),
                                        this.wrapperPlayer
                                            .querySelector(".poster")
                                            .classList.add("active"),
                                        this.options.constrols &&
                                            ((this.wrapperPlayer.querySelector(
                                                ".progress-seek"
                                            ).style.width = "0%"),
                                            this.wrapperPlayer
                                                .querySelector(
                                                    ".progress-input"
                                                )
                                                .setAttribute("value", 0),
                                            (this.wrapperPlayer.querySelector(
                                                ".current-time"
                                            ).innerHTML = "00:00"));
                                },
                            },
                            {
                                key: "togglePlayPause",
                                value: function () {
                                    this.wrapperPlayer.classList.contains(
                                        "paused"
                                    )
                                        ? this.play()
                                        : this.pause();
                                },
                            },
                            {
                                key: "play",
                                value: function () {
                                    this.wrapperPlayer.classList.contains(
                                        "first-start"
                                    ) &&
                                        (this.wrapperPlayer.classList.remove(
                                            "first-start"
                                        ),
                                        this.wrapperPlayer
                                            .querySelector(".poster")
                                            .classList.remove("active")),
                                        this.methodPlay(),
                                        this.afterPlayPause("play");
                                },
                            },
                            {
                                key: "pause",
                                value: function () {
                                    this.methodPause(),
                                        this.afterPlayPause("pause");
                                },
                            },
                            {
                                key: "afterPlayPause",
                                value: function (e) {
                                    "play" === e
                                        ? this.wrapperPlayer.classList.replace(
                                              "paused",
                                              "playing"
                                          )
                                        : this.wrapperPlayer.classList.replace(
                                              "playing",
                                              "paused"
                                          );
                                },
                            },
                            {
                                key: "toggleVolume",
                                value: function () {
                                    this.wrapperPlayer
                                        .querySelector(".volume")
                                        .classList.contains("muted")
                                        ? this.unMute()
                                        : this.mute();
                                },
                            },
                            {
                                key: "mute",
                                value: function () {
                                    this.methodMute(),
                                        this.wrapperPlayer
                                            .querySelector(".volume")
                                            .classList.add("muted");
                                },
                            },
                            {
                                key: "unMute",
                                value: function () {
                                    this.methodUnMute(),
                                        this.wrapperPlayer
                                            .querySelector(".volume")
                                            .classList.remove("muted");
                                },
                            },
                            {
                                key: "seekTo",
                                value: function (e) {
                                    this.setCurrentTime(e);
                                },
                            },
                            {
                                key: "toggleFullscreen",
                                value: function () {
                                    this.isFullScreen
                                        ? this.exitFullscreen()
                                        : this.requestFullscreen();
                                },
                            },
                            {
                                key: "requestFullscreen",
                                value: function () {
                                    var e = this.supportFullScreen.requestFn;
                                    this.player[e] &&
                                        ("mozRequestFullScreen" === e
                                            ? this.player.parentNode[e]()
                                            : this.player[e](),
                                        (this.isFullScreen = !0),
                                        this.wrapperPlayer.classList.add(
                                            "fullscreen-display"
                                        ),
                                        this.wrapperPlayer
                                            .querySelector(".fullscreen")
                                            .classList.add("exit"));
                                },
                            },
                            {
                                key: "exitFullscreen",
                                value: function () {
                                    var e = this.supportFullScreen.cancelFn;
                                    document[e] &&
                                        (document[e](),
                                        this.wrapperPlayer.classList.remove(
                                            "fullscreen-display"
                                        ),
                                        this.wrapperPlayer
                                            .querySelector(".fullscreen")
                                            .classList.remove("exit"),
                                        (this.isFullScreen = !1));
                                },
                            },
                            {
                                key: "updateCurrentTime",
                                value: function () {
                                    var e = Math.round(this.getCurrentTime()),
                                        t = this.getDuration(),
                                        n = (100 * e) / t,
                                        r =
                                            this.wrapperPlayer.querySelector(
                                                ".current-time"
                                            );
                                    (this.wrapperPlayer.querySelector(
                                        ".progress-seek"
                                    ).style.width = n + "%"),
                                        null !== r &&
                                            (r.innerHTML =
                                                this.constructor.formatVideoTime(
                                                    e
                                                ));
                                },
                            },
                            {
                                key: "unBindEvents",
                                value: function () {
                                    var e = this;
                                    [].forEach.call(
                                        this.wrapperPlayer.querySelectorAll(
                                            ".toggle-play-pause-js"
                                        ),
                                        function (t) {
                                            t.removeEventListener(
                                                "click",
                                                e.onClickTogglePlayPause
                                            );
                                        }
                                    ),
                                        this.options.timeline &&
                                            this.wrapperPlayer
                                                .querySelector(
                                                    ".progress-input"
                                                )
                                                .removeEventListener(
                                                    "change",
                                                    this.onChangeProgressBar,
                                                    !1
                                                ),
                                        this.options.volume &&
                                            this.wrapperPlayer
                                                .querySelector(".volume")
                                                .removeEventListener(
                                                    "click",
                                                    this.onCLickToggleVolume
                                                ),
                                        this.options.fullscreen &&
                                            this.wrapperPlayer
                                                .querySelector(".fullscreen")
                                                .removeEventListener(
                                                    "click",
                                                    this.onClickToggleFullscreen
                                                ),
                                        window.removeEventListener(
                                            this.supportFullScreen.changeEvent,
                                            this.onChangeFullScreen
                                        );
                                },
                            },
                            {
                                key: "destroy",
                                value: function () {
                                    this.pause(),
                                        this.unBindEvents(),
                                        "function" ==
                                            typeof this.unBindSpecificEvents &&
                                            this.unBindSpecificEvents(),
                                        "function" ==
                                            typeof this.removeInstance &&
                                            this.removeInstance(),
                                        this.wrapperPlayer.remove();
                                },
                            },
                        ],
                        [
                            {
                                key: "checkSupportFullScreen",
                                value: function () {
                                    var e = ["", "moz", "webkit", "ms", "o"],
                                        t = e.length,
                                        n = void 0,
                                        r = void 0,
                                        o = void 0,
                                        i = void 0,
                                        a = void 0;
                                    if (void 0 !== document.cancelFullscreen)
                                        (r = "requestFullscreen"),
                                            (o = "exitFullscreen"),
                                            (i = "fullscreenchange");
                                    else
                                        for (; t--; )
                                            ("moz" === e[t] &&
                                                !document.mozFullScreenEnabled) ||
                                                void 0 ===
                                                    document[
                                                        e[t] +
                                                            "CancelFullScreen"
                                                    ] ||
                                                ((r =
                                                    e[t] + "RequestFullScreen"),
                                                (o = e[t] + "CancelFullScreen"),
                                                (i = e[t] + "fullscreenchange"),
                                                (a =
                                                    "webkit" === e[t]
                                                        ? e[t] + "IsFullScreen"
                                                        : e[t] + "FullScreen"));
                                    return (
                                        (n = {
                                            requestFn: r,
                                            cancelFn: o,
                                            changeEvent: i,
                                            isFullScreen: a,
                                        }),
                                        !!r && n
                                    );
                                },
                            },
                            {
                                key: "formatVideoTime",
                                value: function (e) {
                                    var t = 1e3 * e,
                                        n = (t / 1e3 / 60) << 0,
                                        r = (t / 1e3) % 60 << 0,
                                        o = "";
                                    return (
                                        (o += n < 10 ? "0" : ""),
                                        (o += n + ":"),
                                        (o += r < 10 ? "0" : ""),
                                        (o += r)
                                    );
                                },
                            },
                            {
                                key: "extend",
                                value: function () {
                                    var e = this,
                                        t = {},
                                        n = !1,
                                        r = 0,
                                        o = arguments.length;
                                    "[object Boolean]" ===
                                        Object.prototype.toString.call(
                                            arguments[0]
                                        ) && ((n = arguments[0]), r++);
                                    for (; r < o; r++) {
                                        var i = arguments[r];
                                        !(function (r) {
                                            for (var o in r)
                                                Object.prototype.hasOwnProperty.call(
                                                    r,
                                                    o
                                                ) &&
                                                    (n &&
                                                    "[object Object]" ===
                                                        Object.prototype.toString.call(
                                                            r[o]
                                                        )
                                                        ? (t[o] =
                                                              e.constructor.extend(
                                                                  !0,
                                                                  t[o],
                                                                  r[o]
                                                              ))
                                                        : (t[o] = r[o]));
                                        })(i);
                                    }
                                    return t;
                                },
                            },
                        ]
                    ),
                    e
                );
            })();
        t.default = i;
    },
    function (e, t, n) {
        "use strict";
        function r(e) {
            return e && e.__esModule ? e : { default: e };
        }
        function o(e, t) {
            if (!(e instanceof t))
                throw new TypeError("Cannot call a class as a function");
        }
        Object.defineProperty(t, "__esModule", { value: !0 });
        var i =
                "function" == typeof Symbol &&
                "symbol" == typeof Symbol.iterator
                    ? function (e) {
                          return typeof e;
                      }
                    : function (e) {
                          return e &&
                              "function" == typeof Symbol &&
                              e.constructor === Symbol &&
                              e !== Symbol.prototype
                              ? "symbol"
                              : typeof e;
                      },
            a = (function () {
                function e(e, t) {
                    for (var n = 0; n < t.length; n++) {
                        var r = t[n];
                        (r.enumerable = r.enumerable || !1),
                            (r.configurable = !0),
                            "value" in r && (r.writable = !0),
                            Object.defineProperty(e, r.key, r);
                    }
                }
                return function (t, n, r) {
                    return n && e(t.prototype, n), r && e(t, r), t;
                };
            })(),
            s = n(2),
            l = r(s),
            u = n(3),
            c = r(u),
            p = { apiLoading: !1, apiReady: !1, apiReadyQueue: [] },
            y = (function () {
                function e(t) {
                    var n = t.selector,
                        r = t.options,
                        a = void 0 === r ? void 0 : r,
                        s = t.callback;
                    o(this, e),
                        (this.player = null),
                        "string" == typeof n
                            ? (this.player = document.querySelector(n))
                            : "object" ===
                                  (void 0 === n ? "undefined" : i(n)) &&
                              (this.player = n),
                        null !== this.player &&
                            ((this.options = a),
                            (this.callback = s),
                            this.initPlayer());
                }
                return (
                    a(e, [
                        {
                            key: "initPlayer",
                            value: function () {
                                this.player.hasAttribute("data-youtube-id")
                                    ? p.apiReady
                                        ? (this.instancePlayer = new c.default({
                                              selector: this.player,
                                              options: this.options,
                                              callback: this.callback,
                                          }))
                                        : (p.apiLoading ||
                                              ((p.apiLoading = !0),
                                              this.loadYoutubeAPI()),
                                          p.apiReadyQueue.push({
                                              player: this.player,
                                              options: this.options,
                                              callback: this.callback,
                                          }))
                                    : (this.instancePlayer = new l.default({
                                          selector: this.player,
                                          options: this.options,
                                          callback: this.callback,
                                      }));
                            },
                        },
                        {
                            key: "loadYoutubeAPI",
                            value: function () {
                                var e = this,
                                    t = document.createElement("script");
                                (t.async = !0),
                                    (t.type = "text/javascript"),
                                    (t.src = "https://youtube.com/iframe_api"),
                                    (window.onYouTubeIframeAPIReady =
                                        function () {
                                            (p.apiReady = !0),
                                                p.apiReadyQueue.forEach(
                                                    function (t) {
                                                        e.instancePlayer =
                                                            new c.default({
                                                                selector:
                                                                    t.player,
                                                                options:
                                                                    t.options,
                                                                callback:
                                                                    t.callback,
                                                            });
                                                    }
                                                ),
                                                (p.apiReadyQueue = []);
                                        }),
                                    document
                                        .getElementsByTagName("body")[0]
                                        .appendChild(t);
                            },
                        },
                        {
                            key: "destroy",
                            value: function () {
                                this.instancePlayer.destroy();
                            },
                        },
                    ]),
                    e
                );
            })();
        (window.vLite = y), (t.default = y);
    },
    function (e, t, n) {
        "use strict";
        function r(e, t) {
            if (!(e instanceof t))
                throw new TypeError("Cannot call a class as a function");
        }
        function o(e, t) {
            if (!e)
                throw new ReferenceError(
                    "this hasn't been initialised - super() hasn't been called"
                );
            return !t || ("object" != typeof t && "function" != typeof t)
                ? e
                : t;
        }
        function i(e, t) {
            if ("function" != typeof t && null !== t)
                throw new TypeError(
                    "Super expression must either be null or a function, not " +
                        typeof t
                );
            (e.prototype = Object.create(t && t.prototype, {
                constructor: {
                    value: e,
                    enumerable: !1,
                    writable: !0,
                    configurable: !0,
                },
            })),
                t &&
                    (Object.setPrototypeOf
                        ? Object.setPrototypeOf(e, t)
                        : (e.__proto__ = t));
        }
        Object.defineProperty(t, "__esModule", { value: !0 });
        var a = (function () {
                function e(e, t) {
                    for (var n = 0; n < t.length; n++) {
                        var r = t[n];
                        (r.enumerable = r.enumerable || !1),
                            (r.configurable = !0),
                            "value" in r && (r.writable = !0),
                            Object.defineProperty(e, r.key, r);
                    }
                }
                return function (t, n, r) {
                    return n && e(t.prototype, n), r && e(t, r), t;
                };
            })(),
            s = function e(t, n, r) {
                null === t && (t = Function.prototype);
                var o = Object.getOwnPropertyDescriptor(t, n);
                if (void 0 === o) {
                    var i = Object.getPrototypeOf(t);
                    return null === i ? void 0 : e(i, n, r);
                }
                if ("value" in o) return o.value;
                var a = o.get;
                if (void 0 !== a) return a.call(r);
            },
            l = n(0),
            u = (function (e) {
                return e && e.__esModule ? e : { default: e };
            })(l),
            c = (function (e) {
                function t(e) {
                    var n = e.selector,
                        i = e.options,
                        a = e.callback;
                    r(this, t);
                    var s = o(
                        this,
                        (t.__proto__ || Object.getPrototypeOf(t)).call(this, {
                            selector: n,
                            options: i,
                            callback: a,
                        })
                    );
                    return (
                        s.waitUntilVideoIsReady().then(s.onPlayerReady.bind(s)),
                        s.skinDisabled || s.bindSpecificEvents(),
                        s
                    );
                }
                return (
                    i(t, e),
                    a(t, [
                        {
                            key: "onPlayerReady",
                            value: function () {
                                s(
                                    t.prototype.__proto__ ||
                                        Object.getPrototypeOf(t.prototype),
                                    "playerIsReady",
                                    this
                                ).call(this);
                            },
                        },
                        {
                            key: "waitUntilVideoIsReady",
                            value: function () {
                                var e = this;
                                return new Promise(function (t, n) {
                                    "number" == typeof e.player.duration &&
                                    !1 === isNaN(e.player.duration)
                                        ? t()
                                        : ((e.onDurationChange = function () {
                                              e.player.removeEventListener(
                                                  "durationchange",
                                                  e.onDurationChange
                                              ),
                                                  e.player.removeEventListener(
                                                      "error",
                                                      e.onError
                                                  ),
                                                  t();
                                          }),
                                          (e.onError = function (t) {
                                              e.player.removeEventListener(
                                                  "error",
                                                  e.onError
                                              ),
                                                  e.player.removeEventListener(
                                                      "durationchange",
                                                      e.onDurationChange
                                                  ),
                                                  n(t);
                                          }),
                                          e.player.addEventListener(
                                              "durationchange",
                                              e.onDurationChange,
                                              !1
                                          ),
                                          e.player.addEventListener(
                                              "error",
                                              e.onError,
                                              !1
                                          ));
                                });
                            },
                        },
                        {
                            key: "bindSpecificEvents",
                            value: function () {
                                var e = this;
                                this.options.controls &&
                                    (this.options.time &&
                                        (this.player.addEventListener(
                                            "loadedmetadata",
                                            function (t) {
                                                return e.updateDuration(t);
                                            },
                                            !1
                                        ),
                                        this.player.addEventListener(
                                            "durationchange",
                                            function (t) {
                                                return e.updateDuration(t);
                                            },
                                            !1
                                        )),
                                    this.player.addEventListener(
                                        "timeupdate",
                                        function (t) {
                                            return e.updateCurrentTime(t);
                                        },
                                        !1
                                    )),
                                    this.player.addEventListener(
                                        "ended",
                                        function (t) {
                                            return e.onVideoEnded(t);
                                        },
                                        !1
                                    );
                            },
                        },
                        {
                            key: "getInstance",
                            value: function () {
                                return this.player;
                            },
                        },
                        {
                            key: "getCurrentTime",
                            value: function () {
                                return this.player.currentTime;
                            },
                        },
                        {
                            key: "setCurrentTime",
                            value: function (e) {
                                this.player.currentTime = e;
                            },
                        },
                        {
                            key: "getDuration",
                            value: function () {
                                return this.player.duration;
                            },
                        },
                        {
                            key: "onProgressChanged",
                            value: function (e) {
                                this.setCurrentTime(
                                    (e.target.value * this.getDuration()) / 100
                                );
                            },
                        },
                        {
                            key: "methodPlay",
                            value: function () {
                                this.player.play();
                            },
                        },
                        {
                            key: "methodPause",
                            value: function () {
                                this.player.pause();
                            },
                        },
                        {
                            key: "methodMute",
                            value: function () {
                                this.player.muted = !0;
                            },
                        },
                        {
                            key: "methodUnMute",
                            value: function () {
                                this.player.muted = !1;
                            },
                        },
                        {
                            key: "unBindSpecificEvents",
                            value: function () {
                                this.options.time &&
                                    (this.player.removeEventListener(
                                        "loadedmetadata",
                                        this.updateDuration
                                    ),
                                    this.player.removeEventListener(
                                        "durationchange",
                                        this.updateDuration
                                    )),
                                    this.player.removeEventListener(
                                        "timeupdate",
                                        this.updateCurrentTime
                                    ),
                                    this.player.removeEventListener(
                                        "play",
                                        this.onPlay
                                    ),
                                    this.player.removeEventListener(
                                        "ended",
                                        this.onVideoEnded
                                    );
                            },
                        },
                    ]),
                    t
                );
            })(u.default);
        t.default = c;
    },
    function (e, t, n) {
        "use strict";
        function r(e, t) {
            if (!(e instanceof t))
                throw new TypeError("Cannot call a class as a function");
        }
        function o(e, t) {
            if (!e)
                throw new ReferenceError(
                    "this hasn't been initialised - super() hasn't been called"
                );
            return !t || ("object" != typeof t && "function" != typeof t)
                ? e
                : t;
        }
        function i(e, t) {
            if ("function" != typeof t && null !== t)
                throw new TypeError(
                    "Super expression must either be null or a function, not " +
                        typeof t
                );
            (e.prototype = Object.create(t && t.prototype, {
                constructor: {
                    value: e,
                    enumerable: !1,
                    writable: !0,
                    configurable: !0,
                },
            })),
                t &&
                    (Object.setPrototypeOf
                        ? Object.setPrototypeOf(e, t)
                        : (e.__proto__ = t));
        }
        Object.defineProperty(t, "__esModule", { value: !0 });
        var a = (function () {
                function e(e, t) {
                    for (var n = 0; n < t.length; n++) {
                        var r = t[n];
                        (r.enumerable = r.enumerable || !1),
                            (r.configurable = !0),
                            "value" in r && (r.writable = !0),
                            Object.defineProperty(e, r.key, r);
                    }
                }
                return function (t, n, r) {
                    return n && e(t.prototype, n), r && e(t, r), t;
                };
            })(),
            s = function e(t, n, r) {
                null === t && (t = Function.prototype);
                var o = Object.getOwnPropertyDescriptor(t, n);
                if (void 0 === o) {
                    var i = Object.getPrototypeOf(t);
                    return null === i ? void 0 : e(i, n, r);
                }
                if ("value" in o) return o.value;
                var a = o.get;
                if (void 0 !== a) return a.call(r);
            },
            l = n(0),
            u = (function (e) {
                return e && e.__esModule ? e : { default: e };
            })(l),
            c = (function (e) {
                function t(e) {
                    var n = e.selector,
                        i = e.options,
                        a = e.callback;
                    r(this, t);
                    var s = o(
                        this,
                        (t.__proto__ || Object.getPrototypeOf(t)).call(this, {
                            selector: n,
                            options: i,
                            callback: a,
                        })
                    );
                    return s.initYoutubePlayer(), s;
                }
                return (
                    i(t, e),
                    a(t, [
                        {
                            key: "initYoutubePlayer",
                            value: function () {
                                var e = this;
                                this.instancePlayer = new YT.Player(
                                    this.player.getAttribute("id"),
                                    {
                                        videoId:
                                            this.player.getAttribute(
                                                "data-youtube-id"
                                            ),
                                        height: "100%",
                                        width: "100%",
                                        playerVars: {
                                            showinfo: 0,
                                            modestbranding: 0,
                                            autohide: 0,
                                            rel: 0,
                                            wmode: "transparent",
                                            controls: this.skinDisabled ? 1 : 0,
                                        },
                                        events: {
                                            onReady: function (t) {
                                                return e.onPlayerReady(t);
                                            },
                                            onStateChange: function (t) {
                                                return e.onPlayerStateChange(t);
                                            },
                                        },
                                    }
                                );
                            },
                        },
                        {
                            key: "onPlayerReady",
                            value: function (e) {
                                (this.player = e.target.getIframe()),
                                    s(
                                        t.prototype.__proto__ ||
                                            Object.getPrototypeOf(t.prototype),
                                        "playerIsReady",
                                        this
                                    ).call(this);
                            },
                        },
                        {
                            key: "getInstance",
                            value: function () {
                                return this.instancePlayer;
                            },
                        },
                        {
                            key: "onPlayerStateChange",
                            value: function (e) {
                                var n = this;
                                switch (e.data) {
                                    case YT.PlayerState.UNSTARTED:
                                        this.options.time &&
                                            s(
                                                t.prototype.__proto__ ||
                                                    Object.getPrototypeOf(
                                                        t.prototype
                                                    ),
                                                "updateDuration",
                                                this
                                            ).call(this);
                                        break;
                                    case YT.PlayerState.ENDED:
                                        s(
                                            t.prototype.__proto__ ||
                                                Object.getPrototypeOf(
                                                    t.prototype
                                                ),
                                            "onVideoEnded",
                                            this
                                        ).call(this);
                                        break;
                                    case YT.PlayerState.PLAYING:
                                        setInterval(function () {
                                            s(
                                                t.prototype.__proto__ ||
                                                    Object.getPrototypeOf(
                                                        t.prototype
                                                    ),
                                                "updateCurrentTime",
                                                n
                                            ).call(n);
                                        }, 100),
                                            s(
                                                t.prototype.__proto__ ||
                                                    Object.getPrototypeOf(
                                                        t.prototype
                                                    ),
                                                "afterPlayPause",
                                                this
                                            ).call(this, "play");
                                        break;
                                    case YT.PlayerState.PAUSED:
                                        s(
                                            t.prototype.__proto__ ||
                                                Object.getPrototypeOf(
                                                    t.prototype
                                                ),
                                            "afterPlayPause",
                                            this
                                        ).call(this, "pause");
                                        break;
                                    case YT.PlayerState.BUFFERING:
                                }
                            },
                        },
                        {
                            key: "setCurrentTime",
                            value: function (e) {
                                this.instancePlayer.seekTo(e);
                            },
                        },
                        {
                            key: "getCurrentTime",
                            value: function () {
                                return this.instancePlayer.getCurrentTime();
                            },
                        },
                        {
                            key: "getDuration",
                            value: function () {
                                return this.instancePlayer.getDuration();
                            },
                        },
                        {
                            key: "onProgressChanged",
                            value: function (e) {
                                this.setCurrentTime(
                                    (e.target.value * this.getDuration()) / 100
                                );
                            },
                        },
                        {
                            key: "methodPlay",
                            value: function () {
                                this.instancePlayer.playVideo();
                            },
                        },
                        {
                            key: "methodPause",
                            value: function () {
                                this.instancePlayer.pauseVideo();
                            },
                        },
                        {
                            key: "methodMute",
                            value: function () {
                                this.instancePlayer.mute();
                            },
                        },
                        {
                            key: "methodUnMute",
                            value: function () {
                                this.instancePlayer.unMute();
                            },
                        },
                        {
                            key: "removeInstance",
                            value: function () {
                                this.instancePlayer.destroy();
                            },
                        },
                    ]),
                    t
                );
            })(u.default);
        t.default = c;
    },
]);
