<?php use_helper('Image') ?>

<?php include_partial('dakGlobal/assets') ?>
<?php slot('title', __('API documentation')) ?>
<h1>API documentation</h1>

<div class="articleMenu">
  <ul>
    <li><a href="#howtoQuery">How to make a query</a>
      <ul>
        <li><a href="#ordinaryQueries">Ordinary queries</a>
          <ul>
            <li><a href="#arranger">Arranger</a></li>
            <li><a href="#location">Location</a></li>
            <li><a href="#category">Category</a></li>
            <li><a href="#event">Event</a></li>
            <li><a href="#festival">Festival</a></li>
          </ul>
        </li>
        <li><a href="#filterQueries">Filter queries and history</a> (this is the one you'll probably most interested in)
          <ul>
            <li><a href="#upcomingEvents">Upcoming events</a></li>
            <li><a href="#filteredEvents">Filtered events</a></li>
            <li><a href="#historyList">History list</a></li>
          </ul>
        </li>
      </ul>
    </li>
    <li><a href="#aNoteOnLocations">A note on locations</a></li>
    <li><a href="#pictureFormats">Picture formats</a></li>
    <li><a href="#responseFormat">Response format</a></li>
    <li><a href="#externalPlugins">External plugins</a>
      <ul>
        <li><a href="#wordpress">Wordpress</a></li>
        <li><a href="#standAloneClient">Stand alone client library</a></li>
      </ul>
    </li>
  </ul>
</div>

<p>
The DAK Event Calendar API makes it possible to create services
that fit your specific needs, ie. a mobile application that displays
upcoming or previous events for your favorite arranger(s)/category(-ies)/location(s)
or all three. It can also create output iCalendar-supported calendars and events.
</p>

<p>It is an open source project, you can find it at <a href="https://github.com/eoma/dakEventsPlugin">github.com</a>.</p>

<h2 id="howtoQuery">How to make a query</h2>

<h3 id="ordinaryQueries">Ordinary queries</h3>

<p>You can query for action, subaction and possible parameters with the format:</p>

<code>
http://eventserver/api/&lt;responseFormat&gt;/&lt;action&gt;/&lt;subaction&gt;?param1=value1&amp;param2=value2&amp;...
</code>

<p>(replace <tt>http://eventserver</tt> with eg. <tt><?php echo public_path('', true) ?></tt>). This format is valid for the following actions:</p>

<ul>
  <li id="arranger">arranger (action)
    <ul>
      <li>get (subaction)
        <ul>
          <li>id (req., integer)</li>
        </ul>
      </li>
      <li>list
        <ul>
          <li>limit</li>
          <li>offset</li>
        </ul>
      </li>
    </ul>
  </li>
  <li id="location">location
    <ul>
      <li>get
        <ul>
          <li>id (req.)</li>
        </ul>
      </li>
      <li>list
        <ul>
          <li>limit</li>
          <li>offset</li>
          <li>master_id (integer, will select all locations that has master_id as ancestor)</li>
          <li>levelDepth (integer)
           <p>levelDepth can only be used together with master_id. Use this to restrict the number of levels below master_id to fetch. If, f.ex., you onlt want to fetch the child locations of master_id, set levelDepth=1, if you want to fetch both children and grandchildren of master_id set levelDepth=2</p>
          </li>
          <li>onlyRoots (bool)
            <p>onlyRoots=1 will only fetch the roots of the location hierarchy. It is useful if you want to build trees and don't want to fetch the whole tree at once, only parts of it when needed. It is to be used as the basis for the trees.</li>
        </ul>
      </li>
    </ul>
  </li>
  <li id="category">category
    <ul>
      <li>get
        <ul>
          <li>id (req.)</li>
        </ul>
      </li>
      <li>list
        <ul>
          <li>limit</li>
          <li>offset</li>
        </ul>
      </li>
    </ul>
  </li>
  <li id="event">event
    <ul>
      <li>get
        <ul>
          <li>id (req.)</li>
          <li>pictureFormat (string, see <a href="#pictureFormats">picture formats</a>, only relevant for event <tt>primaryPicture</tt> and <tt>pictures</tt> variables)</li>
        </ul>
      </li>
    </ul>
  </li>
  <li id="festival">festival
    <ul>
      <li>get
        <ul>
          <li>id (req.)</li>
        </ul>
      </li>
      <li>list
        <ul>
          <li>limit</li>
          <li>offset</li>
          <li>startDate</li>
          <li>endDate</li>
          <li>history (past or future, future is default)</li>
          <li>noCurrentEvents (1 for true, 0 for false, 0 is default)</li>
        </ul>
      </li>
    </ul>
  </li>
</ul>

<h3 id="filterQueries">Filter queries and history</h3>

<p>In addition there are three special actions, they don't have any subactions, only parameters. The query must have the format</p>
<code>
http://eventserver/api/&lt;responseFormat&gt;/&lt;action&gt;?param1=value1&amp;param2=value2&amp;...
</code>

<p>The actions and related optional parameters</p>

<ul>
  <li id="upcomingEvents">upcomingEvents - this action is to be phased out. It will redirect to filteredEvents instead as that action is superior and works in the same way as upcomingEvents.
  </li>
  <li id="filteredEvents">filteredEvents
    <ul>
      <li>location_id (comma seperated values (csv))</li>
      <li>
        <span>master_location_id (csv)</span>
        <p>This parameter will select this location (master_location_id) and all locations having the specified location as ancestor.</p>
      </li>
      <li>arranger_id (csv)</li>
      <li>category_id (csv)</li>
      <li>festival_id (csv)</li>
      <li>event_id (csv)</li>
      <li>history (past or future events, future is default)</li>
      <li>startDate (yyyy-mm-dd format, current date is default if history=future)</li>
      <li>endDate (yyyy-mm-dd format, current date is default if history=past)</li>
      <li>limit (1000 is max)</li>
      <li>offset</li>
      <li>dayspan (maximum days forward to fetch events for)</li>
      <li>noCurrentEvents (bool, 1 for true, 0 for false, 0 is default)
        <p>Useful for spiders wishing to get all public events ever created in a chronological order.</p>
      </li>
      <li>onlySummaries (bool, 1 for true, 0 for false, 0 is default)
        <p>Useful when constructing large lists and you don't want potentially large description fields.</p>
      </li>
      <li>pictureFormat (string, see <a href="#pictureFormats">picture formats</a>, only relevant for event <tt>primaryPicture</tt> and <tt>pictures</tt> variables)</li>
    </ul>
  </li>
  <li id="historyList">historyList
    <p>
      You'll want to use this if you want to construct an overview page of all events
      grouped after month. Also useful for statistical purposes.
    </p>

    <p>
      Each element in the response will contain the variable <tt>yearmonth</tt> and the variable <tt>num</tt>.
      <tt>yearmonth</tt> is a string formatted as YYYYMM, where YYYY is the year and MM is the month.
    </p>

    <span>
     <tt>historyList</tt> accepts the following parameters:
    </span>
    <ul>
      <li>location_id (comma seperated values (csv))</li>
      <li>
        <span>master_location_id (csv)</span>
        <p>This parameter will select this location (master_location_id) and all locations having the specified location as ancestor.</p>
      </li>
      <li>arranger_id (csv)</li>
      <li>category_id (csv)</li>
    </ul>
  </li>
</ul>

<p>The two actions upcomingEvents and filteredEvents are probably the one you'll use the most. <tt>upcomingEvents</tt> is the same as <tt>filteredEvents</tt> without any arguments-</p>

<h2 id="aNoteOnLocations">A note on locations</h2>

<p>
The socalled "commonLocation" variable you will see in <a href="responseFormat">Response format</a> is structured in a hierarchy of a multi root nested set tree (see <a href="http://en.wikipedia.org/wiki/Nested_set_model">Nested set model</a>).
</p>

<p>
When you query for a list of locations each location will contain the variables lft, rgt, level and root_id. 
These variables can be used to construct trees.
</p>

<h2 id="pictureFormats">Picture formats</h2>

These are allowed picture formats to request from the api.

<ul>
<?php foreach (ImageHelper::FormatList() as $n => $f): ?>
  <li><?php echo $n ?><br />
    Max width: <?php echo $f['width'] ?><br />
    Max height: <?php echo $f['height'] ?>
  </li>
<?php endforeach ?>
</ul>

<h2 id="responseFormat">Response format</h2>

<p>
We supply two response formats for general-purpose api requests: <tt>json</tt> and <tt>xml</tt>. 
We supply <tt>atom</tt> for upcoming and filtered events and <tt>ical</tt> (iCalendar) for upcoming and filtered events and also single events or festivals.
</p>

<p>For <tt>json</tt>, a typical response for upcoming events might look like (formatted through <a href="http://jsonlint.com">jsonlint.com</a>)</p>

<pre>
<?php echo esc_entities(file_get_contents(dirname(__FILE__) . '/apiSamples/upcomingEvents.json')) ?>
</pre>

<p>For <tt>xml</tt> it might look like </p>

<pre>
<?php echo esc_entities(file_get_contents(dirname(__FILE__) . '/apiSamples/upcomingEvents.xml')) ?>
</pre>

<p>For <tt>ical</tt> it might look like</p>

<pre>
<?php echo esc_entities(file_get_contents(dirname(__FILE__) . '/apiSamples/upcomingEvents.ical')) ?>
</pre>

<h2 id="externalPlugins">External plugins</h2>

<p>There exist some software for interacting with the event calendar.</p>

<h3 id="wordpress">Wordpress</h3>

<p>Take a look at <a href="https://github.com/eoma/dak_events_wp">dak_events_wp</a>.</p>

<h3 id="standAloneClient">Stand alone client</h3>

<p>Take a look at <a href="https://github.com/eoma/dak_events_wp/blob/master/eventsCalendarClient.php">eventsCalendarClient</a>.</p>
