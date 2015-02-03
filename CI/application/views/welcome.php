{_top_profile_menus}
<div id="welcome_login_wrap">
	<div id="welcome_wrap">
		<div id="welcome_title">
			<h1>Welcome in the Videochat Community of CamXCam! Where are you				going?</h1>
		</div>
		<div id="welcome_text">Camxcam is the video chat offering free entry			to many chat rooms always crowded to meet a lot of people now live			without surprises!</div>
	</div>
	<div id="login_wrap">{login}</div>
</div>
<div class="clear">&nbsp;</div>
<div id="video_chat_free">
	<div id="top_block" class="clearfix">
		<div id="many_friends">
			<a href="#"> <img src="/css/img/many-friends.png" alt="" />
			</a>
		</div>
		<div id="there_are">
			<a href="#">There are</a> <span class="blue_text">{home_online_users}</span>
		</div>
		<div id="users_online">
			<a href="#">users online!</a>
		</div>
	</div>
	<div id="video_chat_box">
		<div id="video_chat_top">
			<img src="/css/img/videochat-free.png" alt="" />
		</div>
		<div id="video_chat_bottom">{home_slider}</div>
	</div>
</div>
<div id="feeds_box">
	<div id="feed_title">
		<h3>Feed</h3>
	</div>
	{feeds} 		{feed_view} 	{/feeds}
	<!--    <div id="feed_title">
        <h3>Feed</h3>
    </div>
    <div class="feed_box clearfix">
        <div class="feed_user_image">
            <a href="#">
                <img src="/css/img/feed-profile-thumb.png" alt="" />
            </a>
        </div>
        <div class="feed_text">
            <div class="feed_meta clearfix">
                <span class="feed_action_icon"><img src="/css/img/feed-album.gif" alt="" /></span>
                <span class="feed_action"><a href="#">Album</a></span>
                <span class="feed_time">- At 20:02:18 -</span>
                <span class="user_feeds"><a href="#">All feed about rodrigo3226 ></a></span>
            </div>
            <div class="feed_description">
                <span class="nickname"><a href="#">rodrigo3226</a></span>
                <span class="action_description">has uploaded a new image on his/her album.</span>
                <span class="user_profile"><a href="#">View profile ></a></span>
            </div>
        </div>
    </div>

    <div class="feed_box clearfix">
        <div class="feed_user_image">
            <a href="#">
                <img src="/css/img/feed-profile-thumb.png" alt="" />
            </a>
        </div>
        <div class="feed_text">
            <div class="feed_meta clearfix">
                <span class="feed_action_icon"><img src="/css/img/feed-album.gif" alt="" /></span>
                <span class="feed_action"><a href="#">Commented image</a></span>
                <span class="feed_time">- At 20:00:11 -</span>
                <span class="user_feeds"><a href="#">All feed about rodrigo3226 ></a></span>
            </div>
            <div class="feed_description">
                <span class="nickname"><a href="#">rodrigo3226</a></span>
                <span class="action_description">has commented the image of</span>
                <span class="user_profile"><a href="#">dolce-sole</a></span>
                <span class="feed_comment">
                    <span class="open_quote"><img src="/css/img/open-quote.png" alt="" /></span>
                    <span class="comment_text">sei bona insomma...</span>
                    <span class="comment_link"><a href="#">View the image ></a></span>
                    <span class="close_quote"><img src="/css/img/close-quote.png" alt="" /></span>
                </span>
            </div>
        </div>
    </div>

    <div class="feed_box clearfix">
        <div class="feed_user_image">
            <a href="#">
                <img src="/css/img/feed-profile-thumb.png" alt="" />
            </a>
        </div>
        <div class="feed_text">
            <div class="feed_meta clearfix">
                <span class="feed_action_icon"><img src="/css/img/feed-new-member.gif" alt="" /></span>
                <span class="feed_action"><a href="#">New member</a></span>
                <span class="feed_time">- At 19:57:02</span>
            </div>
            <div class="feed_description">
                <span class="nickname"><a href="#">lynox</a></span>
                <span class="action_description">is a new member.</span>
                <span class="user_profile"><a href="#">Send a welcome message ></a></span>
            </div>
        </div>
    </div>

    <div class="feed_box clearfix">
        <div class="feed_user_image">
            <a href="#">
                <img src="/css/img/feed-profile-thumb.png" alt="" />
            </a>
        </div>
        <div class="feed_text">
            <div class="feed_meta clearfix">
                <span class="feed_action_icon"><img src="/css/img/feed-new-member.gif" alt="" /></span>
                <span class="feed_action"><a href="#">New member</a></span>
                <span class="feed_time">At 19:54:47</span>
            </div>
            <div class="feed_description">
                <span class="nickname"><a href="#">rodrigo3226</a></span>
                <span class="action_description">is a new member.</span>
                <span class="user_profile"><a href="#">Send a welcome message ></a></span>
            </div>
        </div>
    </div>-->
</div>
<div class="clear">&nbsp;</div>
<div id="groups">
	<div id="groups_title">
		<h3>CamXCam's Groups</h3>
	</div>
	{chat_groups}
	<!-- Group Wrap -->
	<div class="group_box_wrap">
		<div class="group_box clearfix">
			<div class="group_image">
				<a href="/chat/groups/view/{slug}"><img src="{picture}" alt="" /></a>
			</div>
			<div class="group_content">
				<div class="group_title">
					<span class="gr_open_quote"> <img						src="/css/img/open-quote-small.png" alt="" />
					</span>
					<h4>						<a href="/chat/groups/view/{slug}">{message}</a>					</h4>
					<span class="gr_open_quote"> <img						src="/css/img/close-quote-small.png" alt="" />
					</span>
				</div>
				<div class="group_desc">
					<span class="gr_desc_title">Title:</span> {title}
				</div>
				<div class="group_size">
					<span class="gr_size_title">Size:</span> {online}					&nbsp;					<span class="gr_size_title">Type:</span> {chat_type}
				</div>
				<div class="group_wrote">
					Wrote by <span class="gr_wrote_user">{user}</span> on {time}
				</div>
			</div>
			<div class="go_to_group">
				<div class="group_more_wrap">
					<a href="/chat/groups/view/{slug}"> Go to group >> </a>
				</div>
			</div>
		</div>
	</div>
	<!--  End Group Wrap -->
	{/chat_groups}
</div>
<div id="vc_welcome">
	<div id="vc_welcome_title">
		<h2>Welcome to the Videochat Community of CamXCam!</h2>
	</div>
	<div id="vc_welcome_text">
		<p>The most complete Community of the web, choose the area you want.</p>
		<p>			Camxcam è la videochat preferita dalle ragazze, più di 500 stanze			video chat sempre affollate per vedere con chi chatti e conoscere in			diretta tante persone. Entra scegli con chi chattare e vai in pvt.			Videochat Camxcam is preferred by girls, more than 500 video chat			rooms always crowded to see and chat with people.<br /> vt.		</p>
		<p>Enter and choose with whom to chat and go in pvt.</p>
		<p>			Free access with or without registration, the public chat rooms are			free up to maximum capacity.<br /> Camxcam is the best way to make			new friends or meetings, meet new people in video chat directly			without bad surprises.<br /> Friend to meet new friends or Hot if you			are interested in meetings for adults.<br /> If you create your home			page increases the chances of making new friends.		</p>
		<p>Camxcam Friend: thousands of users every day in video chat,			thousands of profiles, forums, blogs and groups.</p>
		<p>Camxcam Hot: to satisfy your erotic fantasies, a lot of videochat			girls connected every day, thousands of profiles and ads always			updated.</p>
		<p>Please, before enter read the community rules.</p>
	</div>
</div>