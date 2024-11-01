<style type="text/css" xmlns="http://www.w3.org/1999/html">
    p.wsrs__blacklist_info {
        display: block;
    }
    ul.wsrs__blacklist {
        display: none;
        list-style: decimal;
        width: 50%;
    }
    ul.wsrs__blacklist li {
        margin: 2px 2px 2px 30px;
        padding: 1px 5px;
    }
    ul.wsrs__blacklist li:nth-child(odd) {
        background-color: #fff;
    }
    div.wsrs__container {
        width: 90%;
        padding: 0;
        margin: 0;
    }
    div.wsrs__container textarea {
        width:100%;
    }
    div.wsrs__column {
        padding: 20px 30px 20px 0;
        float: left;
    }
</style>

<div class="wrap">

    <h2>Stop Referral Spam</h2>

    <?php if(array_key_exists('refresh_message', $data)): ?>
        <?php _e( $data['refresh_message'] ); ?>
    <?php endif; ?>
    <?php if(array_key_exists('invalid_csrf', $data)): ?>
        <?php _e( $data['invalid_csrf'] ); ?>
    <?php endif; ?>
    <?php if(array_key_exists('save_message', $data)): ?>
        <?php _e( $data['save_message'] ); ?>
    <?php endif; ?>

    <div class="wsrs__container">
        <div class="wsrs__column" style="width: 55%;">
            <h3>Information</h3>

            <p>List is updated twice a day.</p>
            <div>
              <form method="post" action="<?php echo WSRS_Helper::plugin_admin_page_url() ?>">
                <input name="force_refresh" type="hidden" value="1" />
                <input name="csrf_token" type="hidden" value="<?php echo $data['csrf_token']; ?>" />
                <input type="submit" class="button button-primary" value="&#10227; Refresh now" />
              </form>
            </div>
            <p><small>Next update is scheduled for <?php echo WSRS_Helper::getNextUpdateTime(true) ?> (UTC).</small></p>

            <h4>Custom URLs</h4>
            <p>Insert only <strong><u>one</u></strong> URL per line.<br />
                Add only high level URL. For example, if you see referrer like
                this in your statistics: <i>claim53693832.copyrightclaims.org</i>,
                add only <i><u>copyrightclaims.org</u></i>.<br />
                Each Custom URL works like a wildcard. Every sub-domain of the URL
                that you set up here, will be blocked. For example, if you put <i>i-spam.com</i> on the list,
                it will block <i>everything.i-spam.com</i> too, as well as <i>low.level.sub-domain.i-spam.com.</i><br />
                <br />
                <strong>Important:</strong> please be <u>very</u> careful what you add here, any traffic from the URLs on this list will be blocked.
            </p>
            <div>
                <form method="post" action="<?php echo WSRS_Helper::plugin_admin_page_url() ?>">
                    <input name="csrf_token" type="hidden" value="<?php echo $data['csrf_token']; ?>" />
                    <textarea name="custom_urls" cols="60" rows="6"><?php echo $data['custom_urls']; ?></textarea>
                    <br />
                    <input type="submit" value="Save" class="button button-primary" />
                </form>
            </div>
        </div>
        <div class="wsrs__column" style="width: 35%;">
            <h3>⭐ Please review ⭐</h3>

            <p>Make my plugin better by reviewing it!
                <a href="https://wordpress.org/support/plugin/stop-referrer-spam/reviews#new-post" target="_blank"><strong style="font-size:16px;">Here</strong></a> you
                can write a review and rate it. Let other people know how awesome it is ;)<br />
                <br />
                Thank you <strong>very</strong> much!
            </p>

            <h2>☕ Buy Me a Coffee ☕</h2>

            <p>If you like what you see, you can say "thank you" by buying me a coffee :)</p>
            <p>
              <a href="https://bmc.link/wieloco" target="_blank">This one is on me dude!</a>
            </p>

            <h4>📨 Spread the word!</h4>

            <p>Share information about this plugin with your friends on social media!</p>
            <p>
                <a target="_blank" href="https://twitter.com/home?status=I%20found%20a%20way%20to%20fight%20referrer%20spam%20with%20this%20cool%20plugin%20https%3A//wordpress.org/plugins/stop-referrer-spam/">Share on Twitter</a>
            </p>

        </div>

    </div>

    <div style="clear: both;"></div>

    <h3 id="wsrs-blacklist">Current blacklist sources:</h3>
    <p>
        &bull; <a href="<?php echo WSRS_Config::WSRS_BLACKLIST_SOURCE_WEBSITE ?>" target="_blank">Matomo Analytics referrer-spam-blacklist</a><br />
    </p>
    <p>
        To add a new URL to the global list please have a look at
        <a target="_blank" href="https://github.com/matomo-org/referrer-spam-blacklist#contributing">Contributing section in Matomo Analytics repository</a>.
    </p>

    <h3>
        Current blacklist: <a id="wsrs__toggle" href="#wsrs-blacklist">expand</a>&nbsp;&nbsp;
        Search for url: <input id="wsrs-search-spammer" type="text" /> found: <span id="wsrs-search-spammer-found"></span>
    </h3>
    <p class="wsrs__blacklist_info">There is <strong><?php echo count($data['blacklist']) ?></strong> blacklisted URLs right now.</p>
    <ul class="wsrs__blacklist"></ul>
</div>


<script type="text/javascript">
  var blacklistJSON = <?php echo json_encode($data['blacklist']); ?>;
  (function () {
    var getByClass = function (className) {
      return document.getElementsByClassName(className)[0];
    };
    var getById = function (elId) {
      return document.getElementById(elId);
    };
    var toggleBtn = getById("wsrs__toggle"),
      searchInput = getById('wsrs-search-spammer'),
      list = getByClass("wsrs__blacklist"),
      info = getByClass("wsrs__blacklist_info");

    var length = function (collection) {
      if (Array.isArray(collection)) {
        return collection.length;
      }
      return Object.keys(collection).length;
    };
    var refreshBlacklist = function (blacklist) {
      var blacklistLength = length(blacklist);
      getById("wsrs-search-spammer-found").innerText = blacklistLength;
      while (list.firstChild) {
        list.removeChild(list.firstChild);
      }
      if (blacklistLength) {
        for (var i=0; i<blacklistLength; i++) {
          var element = document.createElement("li");
          element.innerText = blacklist[i];
          list.appendChild(element);
        }
      }
      else {
        var element = document.createElement("p");
        element.innerText = "Found nothing :(";
        list.appendChild(element);
      }
    };
    var toggleList = function () {
      if (list.style.display === "block") {
        info.style.display = "block";
        list.style.display = "none";
        toggleBtn.text = "expand";
        searchInput.value = "";
        refreshBlacklist(blacklistJSON);
      }
      else {
        info.style.display = "none";
        list.style.display = "block";
        toggleBtn.text = "collapse";
      }
    };
    var search = function () {
      var searchPhrase = searchInput.value,
        filteredBlacklist = [],
        pat = new RegExp(searchPhrase, "g"),
        blacklistLength = length(blacklistJSON);
      if (list.style.display === "none" || list.style.display === "") {
        toggleList();
      }
      for (var i=0; i<blacklistLength; i++) {
        if (blacklistJSON[i].match(pat) !== null) {
          filteredBlacklist.push(blacklistJSON[i]);
        }
      }
      refreshBlacklist(filteredBlacklist);
      getById("wsrs-blacklist").scrollIntoView();
    };

    refreshBlacklist(blacklistJSON);
    toggleBtn.addEventListener("click", toggleList, true);
    searchInput.addEventListener('keyup', search, true);
  })();
</script>
