<?php include_partial('dakGlobal/assets') ?>
<?php slot('title', __('API documentation')) ?>
<h1>API documentation</h1>

<div class="articleMenu">
  <ul>
    <li><a href="#howtoQuery">How to make a query</a></li>
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

<p>You can query for action, subaction and possible parameters with the format:</p>

<code>
http://eventserver/api/&lt;responseFormat&gt;/&lt;action&gt;/&lt;subaction&gt;?param1=value1&amp;param2=value2&amp;...
</code>

<p>(replace <tt>http://eventserver</tt> with eg. <tt><?php echo public_path('', true) ?></tt>). This format is valid for the following actions:</p>

<ul>
  <li>arranger (action)
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
  <li>location
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
  <li>category
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
  <li>event
    <ul>
      <li>get
        <ul>
          <li>id (req.)</li>
        </ul>
      </li>
    </ul>
  </li>
  <li>festival
    <ul>
      <li>get
        <ul>
          <li>id (req.)</li>
        </ul>
      </li>
    </ul>
  </li>
</ul>

<p>In addition there are two special actions, they don't have any subactions, only parameters. The query must have the format</p>
<code>
http://eventserver/api/&lt;responseFormat&gt;/&lt;action&gt;?param1=value1&amp;param2=value2&amp;...
</code>

<p>The actions and related optional parameters</p>

<ul>
  <li>upcomingEvents
    <ul>
      <li>limit</limit>
      <li>offset</limit>
      <li>dayspan</li>
    </ul>
  </li>
  <li>filteredEvents
    <ul>
      <li>location_id (comma seperated values (csv))</li>
      <li>arranger_id (csv)</li>
      <li>category_id (csv)</li>
      <li>festival_id (csv)</li>
      <li>event_id (csv)</li>
      <li>history (past or future, future is default)</li>
      <li>startDate (yyyy-mm-dd format, current date is default if history=future)</li>
      <li>endDate (yyyy-mm-dd format, current date is default if history=past)</li>
      <li>limit (1000 is max)</li>
      <li>offset</li>
      <li>dayspan</li>
      <li>noCurrentEvents (1 for true, 0 for false, 0 is default)</li>
    </ul>
  </li>
</ul>

<p>These two are probably the one you'll use the most. <tt>upcomingEvents</tt> is the same as <tt>filteredEvents</tt> without any arguments-</p>

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
