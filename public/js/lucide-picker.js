/**
 * Lucide Icon Picker - High Performance Virtual Grid
 * Supports 1,800+ Lucide icons with lazy loading & debounced search
 */
(function() {
    const ALL_ICONS = ["a-arrow-down","a-arrow-up","accessibility","activity","ad","airplay","air-vent","a-large-small","alarm-clock","alarm-clock-check","alarm-clock-minus","alarm-clock-off","alarm-clock-plus","alarm-smoke","align-center-horizontal","align-center-vertical","align-end-horizontal","align-end-vertical","align-horizontal-distribute-center","align-horizontal-distribute-end","align-horizontal-distribute-start","align-horizontal-justify-center","align-horizontal-justify-end","align-horizontal-justify-start","align-horizontal-space-around","align-horizontal-space-between","align-start-horizontal","align-start-vertical","align-vertical-distribute-center","align-vertical-distribute-end","align-vertical-distribute-start","align-vertical-justify-center","align-vertical-justify-end","align-vertical-justify-start","align-vertical-space-around","align-vertical-space-between","ambulance","ampersand","ampersands","amphora","anchor","angle","antenna","anvil","aperture","apple","app-window","app-window-mac","archive","archive-restore","archive-x","armchair","arrow-big-down","arrow-big-down-dash","arrow-big-left","arrow-big-left-dash","arrow-big-right","arrow-big-right-dash","arrow-big-up","arrow-big-up-dash","arrow-down","arrow-down-0-1","arrow-down-1-0","arrow-down-a-z","arrow-down-from-line","arrow-down-left","arrow-down-narrow-wide","arrow-down-right","arrow-down-to-dot","arrow-down-to-line","arrow-down-up","arrow-down-wide-narrow","arrow-down-z-a","arrow-left","arrow-left-from-line","arrow-left-right","arrow-left-to-line","arrow-right","arrow-right-from-line","arrow-right-left","arrow-right-to-line","arrows-up-from-line","arrow-up","arrow-up-0-1","arrow-up-1-0","arrow-up-a-z","arrow-up-down","arrow-up-from-dot","arrow-up-from-line","arrow-up-left","arrow-up-narrow-wide","arrow-up-right","arrow-up-to-line","arrow-up-wide-narrow","arrow-up-z-a","asterisk","astroid","atom","at-sign","audio-lines","audio-lines-off","audio-lines-x","audio-waveform","award","axe","axis-3d","baby","backpack","badge","badge-alert","badge-cent","badge-check","badge-dollar-sign","badge-euro","badge-indian-rupee","badge-info","badge-japanese-yen","badge-minus","badge-percent","badge-plus","badge-pound-sterling","badge-question-mark","badge-russian-ruble","badge-swiss-franc","badge-turkish-lira","badge-x","baggage-claim","balloon","ban","banana","bandage","banknote","banknote-arrow-down","banknote-arrow-up","banknote-check","banknote-x","barcode","barrel","baseline","bath","battery","battery-charging","battery-full","battery-low","battery-medium","battery-plus","battery-warning","beaker","bean","bean-off","bed","bed-double","bed-single","beef","beef-off","beer","beer-off","bell","bell-check","bell-dot","bell-electric","bell-minus","bell-off","bell-plus","bell-ring","between-horizontal-end","between-horizontal-start","between-vertical-end","between-vertical-start","biceps-flexed","bike","binary","binoculars","biohazard","bird","birdhouse","bitcoin","blend","blender","blinds","blocks","bluetooth","bluetooth-connected","bluetooth-off","bluetooth-searching","bold","bolt","bomb","bone","bone-fracture","book","book-a","book-alert","book-audio","book-bookmark","book-check","book-copy","book-dashed","book-down","book-headphones","book-heart","book-image","book-key","book-lock","bookmark","bookmark-check","bookmark-minus","bookmark-off","bookmark-plus","bookmark-x","book-minus","book-open","book-open-check","book-open-text","book-plus","book-search","book-text","book-type","book-up","book-up-2","book-user","book-x","boom-box","bot","bot-message-square","bot-off","bottle-wine","bow-arrow","box","boxes","braces","brackets","brain","brain-circuit","brain-cog","brick-wall","brick-wall-fire","brick-wall-shield","bridge","briefcase","briefcase-business","briefcase-conveyor-belt","briefcase-medical","bring-to-front","broccoli","broom","broom-sparkles","brush","brush-cleaning","bubbles","bug","bug-off","bug-play","building","building-complex","building-complex-plus","bus","bus-front","cable","cable-car","cake","cake-slice","calculator","calendar","calendar-1","calendar-arrow-down","calendar-arrow-up","calendar-check","calendar-check-2","calendar-chevrons-right","calendar-clock","calendar-cog","calendar-days","calendar-fold","calendar-heart","calendar-minus","calendar-minus-2","calendar-off","calendar-plus","calendar-plus-2","calendar-range","calendars","calendar-search","calendar-sync","calendar-x","calendar-x-2","camera","camera-off","can","candy","candy-cane","candy-off","cannabis","cannabis-off","can-soda","captions","captions-off","car","caravan","car-battery","card-sim","car-front","carrot","car-taxi-front","carton","carton-off","case-lower","case-sensitive","case-upper","cassette-tape","cast","castle","cat","cctv","cctv-off","chart-area","chart-bar","chart-bar-big","chart-bar-decreasing","chart-bar-increasing","chart-bar-stacked","chart-candlestick","chart-column","chart-column-big","chart-column-decreasing","chart-column-increasing","chart-column-stacked","chart-gantt","chart-line","chart-network","chart-no-axes-column","chart-no-axes-column-decreasing","chart-no-axes-column-increasing","chart-no-axes-combined","chart-no-axes-gantt","chart-pie","chart-scatter","chart-spline","check","check-check","check-line","chef-hat","cherry","chess-bishop","chess-king","chess-knight","chess-pawn","chess-queen","chess-rook","chevron-down","chevron-first","chevron-last","chevron-left","chevron-right","chevrons-down","chevrons-down-up","chevrons-left","chevrons-left-right","chevrons-left-right-ellipsis","chevrons-right","chevrons-right-left","chevrons-up","chevrons-up-down","chevron-up","church","cigarette","cigarette-off","circle","circle-alert","circle-arrow-down","circle-arrow-left","circle-arrow-out-down-left","circle-arrow-out-down-right","circle-arrow-out-up-left","circle-arrow-out-up-right","circle-arrow-right","circle-arrow-up","circle-check","circle-check-big","circle-chevron-down","circle-chevron-left","circle-chevron-right","circle-chevron-up","circle-dashed","circle-dashed-check","circle-divide","circle-dollar-sign","circle-dot","circle-dot-dashed","circle-ellipsis","circle-equal","circle-euro","circle-fading-arrow-up","circle-fading-plus","circle-gauge","circle-minus","circle-off","circle-parking","circle-parking-off","circle-pause","circle-percent","circle-pile","circle-play","circle-plus","circle-pound-sterling","circle-power","circle-question-mark","circle-slash","circle-slash-2","circle-small","circle-star","circle-stop","circle-user","circle-user-round","circle-x","circuit-board","citrus","clapperboard","clef-alto","clef-bass","clef-treble","clipboard","clipboard-check","clipboard-clock","clipboard-copy","clipboard-list","clipboard-minus","clipboard-paste","clipboard-pen","clipboard-pen-line","clipboard-plus","clipboard-type","clipboard-x","clock","clock-1","clock-10","clock-11","clock-12","clock-2","clock-3","clock-4","clock-5","clock-6","clock-7","clock-8","clock-9","clock-alert","clock-arrow-down","clock-arrow-left","clock-arrow-right","clock-arrow-up","clock-check","clock-fading","clock-plus","closed-caption","cloud","cloud-alert","cloud-backup","cloud-check","cloud-cog","cloud-download","cloud-drizzle","cloud-fog","cloud-hail","cloud-lightning","cloud-moon","cloud-moon-rain","cloud-off","cloud-rain","cloud-rain-wind","cloud-snow","cloud-sun","cloud-sun-rain","cloud-sync","cloud-upload","cloudy","clover","club","code","code-xml","coffee","cog","coins","columns-2","columns-3","columns-3-cog","columns-4","combine","command","compass","component","computer","concierge-bell","cone","construction","contact","contact-round","container","contrast","cookie","cooking-pot","copy","copy-check","copyleft","copy-minus","copy-plus","copyright","copy-slash","copy-x","corner-down-left","corner-down-right","corner-left-down","corner-left-up","corner-right-down","corner-right-up","corner-up-left","corner-up-right","cpu","creative-commons","credit-card","credit-card-check","credit-card-minus","credit-card-plus","credit-card-reader","credit-card-x","croissant","crop","cross","crosshair","crown","cuboid","cupcake","cup-soda","currency","cylinder","dam","database","database-arrow-down","database-arrow-up","database-backup","database-check","database-minus","database-plus","database-search","database-x","database-zap","decimals-arrow-left","decimals-arrow-right","delete","dessert","diameter","diamond","diamond-minus","diamond-percent","diamond-plus","dice-1","dice-2","dice-3","dice-4","dice-5","dice-6","dices","diff","disc","disc-2","disc-3","disc-album","divide","dna","dna-off","dock","dog","dollar-sign","dome","donut","door-closed","door-closed-locked","door-closed-package","door-open","door-stairwell","dot","download","drafting-compass","drama","drill","drone","droplet","droplet-off","droplets","drum","drumstick","dumbbell","ear","ear-off","earth","earth-lock","eclipse","egg","egg-fried","egg-off","eject","ellipse","ellipsis","ellipsis-vertical","engine","equal","equal-approximately","equal-approximately-not","equal-not","eraser","ethernet-port","euro","ev-charger","expand","external-link","eye","eye-closed","eye-dashed","eye-off","face-angry","face-expressionless","face-grinning","face-neutral","face-slightly-frowning","face-slightly-smiling","face-slightly-smiling-plus","factory","fan","fast-forward","faucet","feather","fence","ferris-wheel","file","file-archive","file-axis-3d","file-badge","file-box","file-braces","file-braces-corner","file-chart-column","file-chart-column-increasing","file-chart-line","file-chart-pie","file-check","file-check-corner","file-clock","file-code","file-code-corner","file-cog","file-diff","file-digit","file-down","file-exclamation-point","file-headphone","file-heart","file-image","file-input","file-key","file-lock","file-minus","file-minus-corner","file-music","file-output","file-pen","file-pen-line","file-play","file-plus","file-plus-corner","file-question-mark","files","file-scan","file-search","file-search-corner","file-signal","file-sliders","file-spreadsheet","file-stack","file-symlink","file-terminal","file-text","file-type","file-type-corner","file-up","file-user","file-video-camera","file-volume","file-x","file-x-corner","film","fingerprint-pattern","fire-extinguisher","fish","fishing-hook","fishing-rod","fish-off","fish-symbol","flag","flag-off","flag-triangle-left","flag-triangle-right","flame","flame-kindling","flashlight","flashlight-off","flask-conical","flask-conical-off","flask-round","flower","flower-2","focus","folder","folder-archive","folder-bookmark","folder-check","folder-clock","folder-closed","folder-code","folder-cog","folder-dot","folder-down","folder-git","folder-git-2","folder-heart","folder-input","folder-kanban","folder-key","folder-lock","folder-minus","folder-open","folder-open-dot","folder-output","folder-pen","folder-plus","folder-root","folders","folder-search","folder-search-2","folder-symlink","folder-sync","folder-tree","folder-up","folder-x","fold-horizontal","fold-vertical","footprints","forklift","form","forward","frame","fuel","fullscreen","funnel","funnel-plus","funnel-x","galaxy","gallery-horizontal","gallery-horizontal-end","gallery-thumbnails","gallery-vertical","gallery-vertical-end","gamepad","gamepad-2","gamepad-directional","gap-horizontal","gap-vertical","gauge","gavel","gem","georgian-lari","germ","germ-off","ghost","gift","git-branch","git-branch-minus","git-branch-plus","git-commit-horizontal","git-commit-vertical","git-compare","git-compare-arrows","git-fork","git-graph","git-merge","git-merge-conflict","git-pull-request","git-pull-request-arrow","git-pull-request-closed","git-pull-request-create","git-pull-request-create-arrow","git-pull-request-draft","glasses","glass-water","globe","globe-check","globe-code","globe-lock","globe-off","globe-x","goal","gpu","graduation-cap","grape","grid-2x2","grid-2x2-check","grid-2x2-plus","grid-2x2-x","grid-3x2","grid-3x3","grip","grip-horizontal","grip-vertical","group","guitar","ham","hamburger","hammer","hand","handbag","hand-coins","hand-fist","hand-grab","hand-heart","hand-helping","hand-metal","hand-platter","handshake","hard-drive","hard-drive-download","hard-drive-upload","hard-hat","hash","hat-glasses","haze","hd","hdmi-port","heading","heading-1","heading-2","heading-3","heading-4","heading-5","heading-6","headphone-off","headphones","headset","heart","heart-crack","heart-handshake","heart-minus","heart-off","heart-plus","heart-pulse","heart-x","heater","helicopter","hexagon","highlighter","hop","hop-off","hospital","hotel","hourglass","hourglass-cog","house","house-heart","house-plug","house-plus","houses","house-wifi","ice-cream-bowl","ice-cream-cone","id-card","id-card-lanyard","image","image-down","image-minus","image-off","image-play","image-plus","images","image-up","image-upscale","import","inbox","indian-rupee","infinity","info","inspection-panel","italic","iteration-ccw","iteration-cw","iv-bag","japanese-yen","joystick","kanban","kayak","key","keyboard","keyboard-music","keyboard-off","key-round","key-square","lambda","lamp","lamp-ceiling","lamp-desk","lamp-floor","lamp-wall-down","lamp-wall-up","landmark","land-plot","languages","laptop","laptop-minimal","laptop-minimal-check","lasso","lasso-select","layer-arrow-down","layer-arrow-up","layers","layers-2","layers-arrow-down","layers-arrow-up","layers-minus","layers-plus","layout-arrow-down","layout-arrow-right","layout-dashboard","layout-freeform","layout-grid","layout-list","layout-panel-left","layout-panel-top","layout-template","leaf","leafy-green","lectern","lens-concave","lens-convex","library","library-big","life-buoy","ligature","lightbulb","lightbulb-off","lighthouse","line-dot-right-horizontal","line-squiggle","line-style","link","link-2","link-2-off","list","list-check","list-checks","list-chevrons-down-up","list-chevrons-up-down","list-clock","list-collapse","list-end","list-filter","list-filter-plus","list-indent-decrease","list-indent-increase","list-minus","list-music","list-ordered","list-plus","list-restart","list-sort-ascending","list-sort-descending","list-start","list-todo","list-tree","list-video","list-x","loader","loader-circle","loader-pinwheel","locate","locate-fixed","locate-off","lock","lock-keyhole","lock-keyhole-open","lock-open","log-in","log-out","logs","lollipop","luggage","magnet","mail","mail-badge","mailbox","mail-check","mail-clock","mail-minus","mail-open","mail-pen","mail-plus","mail-question-mark","mails","mail-search","mail-warning","mail-x","map","map-minus","map-pin","map-pin-check","map-pin-check-inside","map-pin-house","map-pin-minus","map-pin-minus-inside","map-pinned","map-pin-off","map-pin-pen","map-pin-plus","map-pin-plus-inside","map-pin-search","map-pin-x","map-pin-x-inside","map-plus","mars","mars-stroke","martini","maximize","maximize-2","medal","megaphone","megaphone-off","memory-stick","menu","merge","message-circle","message-circle-check","message-circle-code","message-circle-dashed","message-circle-dashed-check","message-circle-heart","message-circle-more","message-circle-off","message-circle-plus","message-circle-question-mark","message-circle-reply","message-circle-warning","message-circle-x","messages-circle","message-square","message-square-check","message-square-code","message-square-dashed","message-square-diff","message-square-dot","message-square-heart","message-square-lock","message-square-more","message-square-off","message-square-plus","message-square-quote","message-square-reply","message-square-share","message-square-text","message-square-warning","message-square-x","messages-square","metronome","mic","mic-audio-lines","mic-off","microchip","microscope","microwave","mic-signal","mic-vocal","midi-port","milestone","milk","milk-off","minimize","minimize-2","minus","mirror-rectangular","mirror-round","monitor","monitor-check","monitor-cloud","monitor-cog","monitor-dot","monitor-down","monitor-off","monitor-pause","monitor-pc","monitor-play","monitor-smartphone","monitor-speaker","monitor-stop","monitor-up","monitor-x","moon","moon-star","mop","mop-sparkles","mosque","motorbike","mountain","mountain-snow","mouse","mouse-left","mouse-off","mouse-pointer","mouse-pointer-2","mouse-pointer-2-off","mouse-pointer-ban","mouse-pointer-click","mouse-right","mouth","mouth-off","move","move-3d","move-diagonal","move-diagonal-2","move-down","move-down-left","move-down-right","move-horizontal","move-left","move-right","move-up","move-up-left","move-up-right","move-vertical","music","music-2","music-3","music-4","navigation","navigation-2","navigation-2-off","navigation-off","nepali-rupee","network","newspaper","nfc","non-binary","notebook","notebook-dot","notebook-pen","notebook-tabs","notebook-text","notepad-text","notepad-text-dashed","nut","nut-off","octagon","octagon-alert","octagon-minus","octagon-pause","octagon-x","omega","option","orbit","origami","package","package-2","package-check","package-minus","package-open","package-plus","package-search","package-x","paintbrush","paintbrush-vertical","paint-bucket","paint-roller","palette","panda","panel-bottom","panel-bottom-close","panel-bottom-dashed","panel-bottom-open","panel-left","panel-left-close","panel-left-dashed","panel-left-open","panel-left-right-dashed","panel-right","panel-right-close","panel-right-dashed","panel-right-open","panels-left-bottom","panels-right-bottom","panels-top-left","panel-top","panel-top-bottom-dashed","panel-top-close","panel-top-dashed","panel-top-open","paper-bag","paperclip","parasol","parentheses","park","parking-meter","party-popper","pause","paw-print","pc-case","pen","pencil","pencil-line","pencil-off","pencil-ruler","pencil-sparkles","pen-line","pen-off","pentagon","pen-tool","percent","person-standing","phi","philippine-peso","phone","phone-call","phone-forwarded","phone-incoming","phone-missed","phone-off","phone-outgoing","pi","piano","pickaxe","picture-in-picture","picture-in-picture-2","piggy-bank","pilcrow","pilcrow-left","pilcrow-right","pill","pill-bottle","pin","pin-off","pipette","pizza","plane","plane-landing","plane-takeoff","plant-pot","play","playing-card","playing-cards","playing-cards-fan","play-off","plug","plug-2","plug-zap","plus","pocket-knife","podium","pointer","pointer-off","popcorn","popsicle","pound-sterling","power","power-off","presentation","printer","printer-check","printer-x","projector","proportions","puzzle","pyramid","qr-code","quote","rabbit","radar","radiation","radical","radio","radio-off","radio-receiver","radio-tower","radius","rainbow","rat","ratio","receipt","receipt-cent","receipt-euro","receipt-indian-rupee","receipt-japanese-yen","receipt-pound-sterling","receipt-russian-ruble","receipt-swiss-franc","receipt-text","receipt-turkish-lira","rectangle-circle","rectangle-ellipsis","rectangle-goggles","rectangle-horizontal","rectangle-vertical","recycle","redo","redo-2","redo-dot","refresh-ccw","refresh-ccw-dot","refresh-cw","refresh-cw-off","refrigerator","regex","remove-formatting","repeat","repeat-1","repeat-2","repeat-off","replace","replace-all","reply","reply-all","rewind","ribbon","road","robot-arm","robot-vacuum","rocket","rocking-chair","roller-coaster","rose","rotate-3d","rotate-ccw","rotate-ccw-clock","rotate-ccw-key","rotate-ccw-square","rotate-cw","rotate-cw-clock","rotate-cw-fading-clock","rotate-cw-square","route","route-off","router","rows-2","rows-3","rows-4","rss","ruler","ruler-dimension-line","russian-ruble","sailboat","salad","sandwich","satellite","satellite-dish","saudi-riyal","save","save-all","save-check","save-off","save-pen","save-plus","scale","scale-3d","scaling","scan","scan-barcode","scan-box","scan-eye","scan-face","scan-heart","scan-line","scan-qr-code","scan-search","scan-square","scan-text","school","scissors","scissors-line-dashed","scooter","screen-share","screen-share-off","scroll","scroll-text","search","search-alert","search-check","search-code","search-slash","search-x","section","send","send-horizontal","send-to-back","separator-horizontal","separator-vertical","server","server-cog","server-crash","server-off","server-plus","settings","settings-2","shapes","share","share-2","sheet","shell","shelving-unit","shield","shield-alert","shield-ban","shield-check","shield-cog","shield-cog-corner","shield-ellipsis","shield-half","shield-keyhole","shield-lock","shield-minus","shield-off","shield-plus","shield-question-mark","shield-user","shield-x","ship","ship-cargo","ship-wheel","shirt","shopping-bag","shopping-basket","shopping-cart","shopping-cart-minus","shopping-cart-plus","shovel","shower-head","shredder","shrimp","shrimp-off","shrink","shrub","shuffle","sigma","signal","signal-high","signal-low","signal-medium","signal-zero","signature","signpost","signpost-big","siren","skip-back","skip-forward","skull","slash","slice","sliders-horizontal","sliders-vertical","smartphone","smartphone-charging","smartphone-nfc","snail","snowflake","soap-dispenser-droplet","sofa","solar-panel","soup","space","spade","sparkle","sparkles","speaker","speech","spell-check","spell-check-2","spline","spline-pointer","split","spool","sport-shoe","spotlight","spray-can","sprout","square","square-activity","square-arrow-down","square-arrow-down-left","square-arrow-down-right","square-arrow-left","square-arrow-out-down-left","square-arrow-out-down-right","square-arrow-out-up-left","square-arrow-out-up-right","square-arrow-right","square-arrow-right-enter","square-arrow-right-exit","square-arrow-up","square-arrow-up-left","square-arrow-up-right","square-asterisk","square-bookmark","square-bottom-dashed-scissors","square-centerline-dashed-horizontal","square-centerline-dashed-vertical","square-chart-gantt","square-check","square-check-big","square-chevron-down","square-chevron-left","square-chevron-right","square-chevron-up","square-code","square-dashed","square-dashed-bottom","square-dashed-bottom-code","square-dashed-kanban","square-dashed-mouse-pointer","square-dashed-text","square-dashed-top-solid","square-dashed-x","square-dashed-x-corner","square-dimensions","square-divide","square-dot","square-equal","square-exclamation-point","square-function","square-kanban","square-library","square-m","square-menu","square-minus","square-mouse-pointer","square-off","square-parking","square-parking-off","square-pause","square-pen","square-percent","square-pi","square-pilcrow","square-play","square-plus","square-power","square-radical","square-round-corner","square-scissors","squares-exclude","square-sigma","squares-intersect","square-slash","square-split-horizontal","square-split-vertical","square-square","squares-subtract","square-stack","square-star","square-stop","squares-unite","square-terminal","square-text","square-user","square-user-round","square-x","squircle","squircle-dashed","squirrel","stamp","star","star-check","star-half","star-minus","star-off","star-plus","star-x","step-back","step-forward","stethoscope","sticker","sticky-note","sticky-note-check","sticky-note-minus","sticky-note-off","sticky-note-plus","sticky-notes","sticky-note-x","stone","store","stretch-horizontal","stretch-vertical","strikethrough","subscript","summary","sun","sun-dim","sun-medium","sun-moon","sunrise","sunset","sun-snow","superscript","swatch-book","swiss-franc","switch-camera","sword","swords","syringe","table","table-2","table-cells-merge","table-cells-split","table-columns-split","table-of-contents","table-properties","table-rows-split","tablet","tablets","tablet-smartphone","tag","tag-plus","tags","tag-x","tally-1","tally-2","tally-3","tally-4","tally-5","tangent","target","telescope","tent","tent-tree","terminal","test-tube","test-tube-diagonal","test-tubes","text-align-center","text-align-end","text-align-justify","text-align-start","text-cursor","text-cursor-input","text-initial","text-quote","text-search","text-wrap","theater","thermometer","thermometer-snowflake","thermometer-sun","thumbs-down","thumbs-up","ticket","ticket-check","ticket-minus","ticket-percent","ticket-plus","tickets","ticket-slash","tickets-plane","ticket-x","tic-tac-toe","timeline","timer","timer-off","timer-reset","toggle-left","toggle-right","toilet","toolbox","tool-case","toothbrush","toothbrush-sparkles","tornado","torus","touchpad","touchpad-off","towel-rack","tower-control","toy-brick","tractor","traffic-cone","trailer","train-front","train-front-tunnel","train-track","tram-front","transgender","trash","trash-off","tree-deciduous","tree-palm","tree-pine","trees","trending-down","trending-up","trending-up-down","triangle","triangle-alert","triangle-dashed","triangle-right","triangles-centerline-dashed-horizontal","triangles-centerline-dashed-vertical","trophy","truck","truck-electric","tube-lotion","turkish-lira","turntable","turtle","tv","tv-minimal","tv-minimal-play","type","type-outline","umbrella","umbrella-off","underline","undo","undo-2","undo-dot","unfold-horizontal","unfold-vertical","ungroup","university","unlink","unlink-2","unplug","upload","usb","usb-c-port","user","user-check","user-cog","user-group","user-key","user-lock","user-minus","user-pen","user-plus","user-round","user-round-arrow-left","user-round-check","user-round-cog","user-round-group","user-round-key","user-round-minus","user-round-pen","user-round-plus","user-round-search","user-round-x","users","user-search","user-shield","users-round","user-star","user-x","utensils","utensils-crossed","utility-pole","van","variable","vault","vector-polygon","vector-square","vegan","venetian-mask","venus","venus-and-mars","vibrate","vibrate-off","video","video-off","videotape","view","virus","virus-off","voicemail","volleyball","volume","volume-1","volume-2","volume-off","volume-x","vote","wallet","wallet-cards","wallet-minimal","wallpaper","wand","wand-sparkles","warehouse","washing-machine","watch","waves-arrow-down","waves-arrow-up","waves-horizontal","waves-ladder","waves-vertical","waypoints","webcam","webcam-off","webhook","webhook-off","weight","weight-tilde","wheat","wheat-off","whistle","whole-word","wifi","wifi-cog","wifi-high","wifi-low","wifi-off","wifi-pen","wifi-sync","wifi-zero","wind","wind-arrow-down","wine","wine-off","workflow","worm","wrench","wrench-off","x","x-line-top","zap","zap-off","zodiac-aquarius","zodiac-aries","zodiac-cancer","zodiac-capricorn","zodiac-gemini","zodiac-leo","zodiac-libra","zodiac-ophiuchus","zodiac-pisces","zodiac-sagittarius","zodiac-scorpio","zodiac-taurus","zodiac-virgo","zoom-in","zoom-out"];

    const POPULAR_ICONS = [
        'home', 'heart', 'star', 'user', 'users', 'settings', 'search', 'mail',
        'phone', 'map-pin', 'calendar', 'clock', 'check', 'check-circle', 'x', 'x-circle',
        'plus', 'minus', 'edit', 'trash-2', 'eye', 'eye-off', 'lock', 'unlock',
        'shield', 'award', 'gift', 'bookmark', 'tag', 'flag', 'bell', 'message-circle',
        'send', 'share-2', 'download', 'upload', 'file', 'file-text', 'folder', 'image',
        'camera', 'video', 'music', 'mic', 'headphones', 'volume-2', 'wifi', 'bluetooth',
        'monitor', 'smartphone', 'tablet', 'laptop', 'printer', 'cpu', 'hard-drive', 'database',
        'globe', 'map', 'compass', 'navigation', 'sun', 'moon', 'cloud', 'cloud-rain',
        'umbrella', 'thermometer', 'wind', 'droplets', 'zap', 'battery', 'plug', 'power',
        'activity', 'chart-bar', 'chart-pie', 'trending-up', 'trending-down', 'percent', 'dollar-sign', 'credit-card',
        'shopping-cart', 'shopping-bag', 'package', 'truck', 'car', 'plane', 'train', 'ship',
        'bike', 'bus', 'building', 'store', 'warehouse', 'school', 'graduation-cap', 'book',
        'book-open', 'library', 'pencil', 'palette', 'calculator', 'clipboard', 'layers', 'layout',
        'grid-3x3', 'list', 'code', 'coffee', 'utensils', 'apple', 'leaf', 'flower-2',
        'trees', 'sprout', 'target', 'qr-code', 'key', 'rocket', 'sparkles', 'flame',
        'lightbulb', 'recycle', 'thumbs-up', 'megaphone', 'stethoscope', 'pill', 'brain'
    ];

    const PAGE_SIZE = 72;
    let activeTrigger = null;
    let currentCategory = 'all';
    let currentSearchQuery = '';
    let filteredIcons = ALL_ICONS;
    let renderedCount = 0;
    let searchDebounceTimer = null;
    let scrollObserver = null;

    // Category filter mapping
    function filterByCategoryList(category, list) {
        if (category === 'all') return list;
        if (category === 'popular') return list.filter(name => POPULAR_ICONS.includes(name));

        const matchRules = {
            'arrows': ['arrow', 'chevron', 'corner', 'move', 'rotate', 'undo', 'redo', 'chevrons'],
            'media': ['video', 'audio', 'music', 'camera', 'image', 'play', 'pause', 'mic', 'speaker', 'volume', 'disc', 'film', 'headphones'],
            'communication': ['mail', 'message', 'phone', 'chat', 'send', 'share', 'bell', 'contact', 'rss', 'at-sign'],
            'devices': ['monitor', 'smartphone', 'tablet', 'laptop', 'cpu', 'hard-drive', 'database', 'server', 'wifi', 'bluetooth', 'printer', 'tv', 'keyboard', 'mouse'],
            'files': ['file', 'folder', 'clipboard', 'archive', 'book', 'notebook', 'receipt', 'page'],
            'commerce': ['shopping', 'cart', 'bag', 'credit', 'dollar', 'percent', 'banknote', 'tag', 'wallet', 'coins', 'store', 'package', 'badge-dollar'],
            'weather': ['sun', 'moon', 'cloud', 'rain', 'wind', 'droplet', 'snowflake', 'thermometer', 'umbrella', 'rainbow'],
            'nature': ['leaf', 'tree', 'flower', 'sprout', 'flame', 'apple', 'fish', 'bird', 'cat', 'dog', 'rabbit', 'bug'],
            'shapes': ['circle', 'square', 'triangle', 'hexagon', 'diamond', 'octagon', 'pentagon', 'star', 'heart', 'gem'],
            'health': ['heart-pulse', 'hospital', 'pill', 'stethoscope', 'syringe', 'bandage', 'activity', 'bone', 'brain', 'ambulance', 'cross'],
            'food': ['coffee', 'utensils', 'pizza', 'apple', 'cake', 'soup', 'beer', 'wine', 'cooking', 'cup', 'sandwich', 'salad', 'croissant'],
            'transport': ['car', 'truck', 'bus', 'bike', 'plane', 'train', 'ship', 'navigation', 'map', 'compass', 'fuel'],
            'buildings': ['building', 'house', 'hotel', 'warehouse', 'school', 'church', 'castle', 'store', 'factory', 'landmark'],
            'charts': ['chart', 'trending', 'bar-chart', 'pie-chart', 'presentation'],
            'dev': ['code', 'terminal', 'git', 'bug', 'variable', 'braces', 'brackets', 'binary', 'workflow']
        };

        const keywords = matchRules[category];
        if (!keywords) return list;

        return list.filter(name => keywords.some(kw => name.includes(kw)));
    }

    function updateFilteredList() {
        let list = ALL_ICONS;

        // Apply category
        list = filterByCategoryList(currentCategory, list);

        // Apply search query
        if (currentSearchQuery) {
            const q = currentSearchQuery.toLowerCase().trim();
            list = list.filter(name => name.includes(q));
        }

        filteredIcons = list;
        renderedCount = 0;
    }

    function renderNextBatch() {
        const grid = document.getElementById('icon-grid');
        const counter = document.getElementById('icon-counter');
        const noResults = document.getElementById('icon-no-results');
        if (!grid) return;

        if (filteredIcons.length === 0) {
            grid.innerHTML = '';
            if (noResults) noResults.classList.remove('hidden');
            if (counter) counter.textContent = '0 icon ditemukan';
            return;
        }

        if (noResults) noResults.classList.add('hidden');

        const nextBatch = filteredIcons.slice(renderedCount, renderedCount + PAGE_SIZE);
        if (nextBatch.length === 0) return;

        const fragment = document.createDocumentFragment();

        nextBatch.forEach(name => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'icon-grid-item aspect-square flex flex-col items-center justify-center p-1 rounded-xl border border-gray-100 hover:border-emerald-500 hover:bg-emerald-50 text-slate-600 hover:text-emerald-700 transition-all cursor-pointer group focus:outline-none focus:ring-2 focus:ring-emerald-500/30';
            btn.title = name;
            btn.setAttribute('data-icon-name', name);
            btn.onclick = () => window.selectLucideIcon(name);

            btn.innerHTML = `
                <i data-lucide="${name}" class="w-5 h-5 mb-0.5 transition-transform group-hover:scale-110"></i>
                <span class="text-[9px] text-slate-400 group-hover:text-emerald-700 truncate w-full text-center px-0.5">${name}</span>
            `;

            fragment.appendChild(btn);
        });

        // Convert icons inside fragment before DOM attachment
        if (typeof lucide !== 'undefined') {
            try {
                lucide.createIcons({ root: fragment });
            } catch (e) {
                // Continue to fallback
            }
        }

        grid.appendChild(fragment);
        renderedCount += nextBatch.length;

        // Fallback check if any icons need rendering inside grid
        if (typeof lucide !== 'undefined' && grid.querySelector('i[data-lucide]')) {
            lucide.createIcons({ root: grid });
        }

        // Update counter
        if (counter) {
            const total = filteredIcons.length;
            if (currentSearchQuery || currentCategory !== 'all') {
                counter.textContent = `Menampilkan ${renderedCount} dari ${total} icon (${ALL_ICONS.length} total)`;
            } else {
                counter.textContent = `Menampilkan ${renderedCount} dari ${total} icon`;
            }
        }
    }

    function resetAndRenderGrid() {
        const grid = document.getElementById('icon-grid');
        if (grid) grid.innerHTML = '';
        renderedCount = 0;
        updateFilteredList();
        renderNextBatch();

        // Scroll back to top
        const container = document.getElementById('icon-grid-container');
        if (container) container.scrollTop = 0;
    }

    function setupIntersectionObserver() {
        const sentinel = document.getElementById('icon-scroll-sentinel');
        const container = document.getElementById('icon-grid-container');
        if (!sentinel || !container) return;

        if (scrollObserver) {
            scrollObserver.disconnect();
        }

        scrollObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && renderedCount < filteredIcons.length) {
                    renderNextBatch();
                }
            });
        }, {
            root: container,
            rootMargin: '120px'
        });

        scrollObserver.observe(sentinel);
    }

    // Public API
    window.openIconPicker = function(triggerBtn) {
        activeTrigger = triggerBtn;
        const modal = document.getElementById('icon-picker-modal');
        const searchInput = document.getElementById('icon-search-input');
        if (!modal) return;

        // Unhide modal first so dimensions are computed
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        // Reset state
        currentCategory = 'all';
        currentSearchQuery = '';
        if (searchInput) searchInput.value = '';

        // Reset category buttons UI
        document.querySelectorAll('.icon-cat-btn').forEach(btn => {
            const isAll = btn.getAttribute('data-cat') === 'all';
            btn.className = isAll
                ? 'icon-cat-btn active px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-emerald-100 text-emerald-700'
                : 'icon-cat-btn px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-gray-100 text-slate-500 hover:bg-gray-200';
        });

        resetAndRenderGrid();
        setupIntersectionObserver();

        setTimeout(() => {
            if (searchInput) searchInput.focus();
        }, 120);
    };

    window.closeIconPicker = function() {
        const modal = document.getElementById('icon-picker-modal');
        if (modal) modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        activeTrigger = null;
    };

    window.filterByCategory = function(category) {
        currentCategory = category;

        document.querySelectorAll('.icon-cat-btn').forEach(btn => {
            const isMatch = btn.getAttribute('data-cat') === category;
            btn.className = isMatch
                ? 'icon-cat-btn active px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-emerald-100 text-emerald-700 font-semibold'
                : 'icon-cat-btn px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-gray-100 text-slate-500 hover:bg-gray-200';
        });

        resetAndRenderGrid();
    };

    window.debouncedFilterIcons = function(query) {
        clearTimeout(searchDebounceTimer);
        searchDebounceTimer = setTimeout(() => {
            currentSearchQuery = query;
            resetAndRenderGrid();
        }, 150);
    };

    window.selectLucideIcon = function(iconName) {
        if (!activeTrigger) return;

        // Support both:
        // 1) Reusable Component wrapper: .icon-picker-component
        // 2) Traditional card item: .card-item
        const wrapper = activeTrigger.closest('.icon-picker-component') ||
                        activeTrigger.closest('.card-item') ||
                        activeTrigger.parentElement;

        if (wrapper) {
            // Find hidden input
            const input = wrapper.querySelector('.icon-picker-input, .card-icon-name-input');
            if (input) {
                input.value = iconName;
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }

        // Update trigger UI
        const preview = activeTrigger.querySelector('.icon-picker-preview');
        const label = activeTrigger.querySelector('.icon-picker-label');
        const clearBtn = activeTrigger.querySelector('.icon-picker-clear');

        if (preview) {
            preview.innerHTML = `<i data-lucide="${iconName}" class="w-4 h-4 text-emerald-600"></i>`;
            if (typeof lucide !== 'undefined') {
                lucide.createIcons({ root: preview });
            }
        }
        if (label) {
            label.textContent = iconName;
            label.classList.remove('text-slate-600', 'text-slate-400');
            label.classList.add('text-slate-900', 'font-semibold');
        }
        if (clearBtn) {
            clearBtn.classList.remove('hidden');
        }

        window.closeIconPicker();
    };

    window.clearSelectedIcon = function(clearBtn) {
        const trigger = clearBtn.closest('.icon-picker-trigger');
        const wrapper = trigger ? (trigger.closest('.icon-picker-component') || trigger.closest('.card-item') || trigger.parentElement) : null;

        if (wrapper) {
            const input = wrapper.querySelector('.icon-picker-input, .card-icon-name-input');
            if (input) {
                input.value = '';
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }

        if (trigger) {
            const preview = trigger.querySelector('.icon-picker-preview');
            const label = trigger.querySelector('.icon-picker-label');
            const placeholder = trigger.getAttribute('data-placeholder') || 'Pilih Icon Lucide...';

            if (preview) {
                preview.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>';
            }
            if (label) {
                label.textContent = placeholder;
                label.classList.remove('text-slate-900', 'font-semibold');
                label.classList.add('text-slate-600');
            }
        }
        clearBtn.classList.add('hidden');
    };

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            window.closeIconPicker();
        }
    });

    // Custom image upload preview helpers
    window.handleIconImagePreview = function(input) {
        const file = input.files[0];
        if (!file) return;

        if (file.size > 512 * 1024) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran File Terlalu Besar',
                    text: 'Maksimal ukuran icon custom adalah 512KB.',
                    confirmButtonColor: '#e11d48'
                });
            } else {
                alert('Maksimal ukuran icon custom adalah 512KB.');
            }
            input.value = '';
            return;
        }

        const zone = input.closest('.icon-upload-zone');
        if (!zone) return;
        const previewDiv = zone.querySelector('.icon-upload-preview');
        const previewImg = zone.querySelector('.icon-upload-preview-img');
        const placeholder = zone.querySelector('.icon-upload-placeholder');
        const cardItem = input.closest('.card-item') || input.closest('.icon-picker-component');
        const removeFlag = cardItem ? cardItem.querySelector('.card-remove-icon-flag, .icon-remove-flag') : null;

        if (removeFlag) removeFlag.value = '0';

        const reader = new FileReader();
        reader.onload = function(e) {
            if (previewImg) previewImg.src = e.target.result;
            if (previewDiv) previewDiv.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    };

    window.removeIconImage = function(btn) {
        const zone = btn.closest('.icon-upload-zone');
        if (!zone) return;
        const input = zone.querySelector('.card-icon-image-input, .icon-image-input');
        const previewDiv = zone.querySelector('.icon-upload-preview');
        const previewImg = zone.querySelector('.icon-upload-preview-img');
        const placeholder = zone.querySelector('.icon-upload-placeholder');
        const cardItem = zone.closest('.card-item') || zone.closest('.icon-picker-component');
        const removeFlag = cardItem ? cardItem.querySelector('.card-remove-icon-flag, .icon-remove-flag') : null;

        if (removeFlag) removeFlag.value = '1';
        if (input) input.value = '';
        if (previewImg) previewImg.src = '#';
        if (previewDiv) previewDiv.classList.add('hidden');
        if (placeholder) placeholder.classList.remove('hidden');
    };

    // Auto-init Lucide when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
})();
