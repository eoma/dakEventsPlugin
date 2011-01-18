<?php include_partial('dakGlobal/assets') ?>
<?php slot('title', __('API documentation')) ?>
<h1>API documentation</h1>

<div class="articleMenu">
  <ul>
    <li><a href="#howtoQuery">How to make a query</a></li>
    <li><a href="#responseFormat">Response format</a></li>
  </ul>
</div>

<p>
The DAK Event Calendar API makes it possible to create services
that fit your specific needs, ie. a mobile application that displays
upcoming or previous events for your favorite arranger(s)/category(-ies)/location(s)
or all three.
</p>

<h2 id="howtoQuery">How to make a query</h2>

<p>You can query for action, subaction and possible parameters with the format:</p>

<code>
http://eventserver/api/&lt;responseFormat&gt;/&lt;action&gt;/&lt;subaction&gt;?param1=value1&amp;param2=value2&amp;...
</code>

<p>(replace <tt>http://eventserver</tt> with eg. <tt><?php echo public_path('', true) ?></tt>). This format is valid the following actions:</p>

<ul>
  <li>arranger (action)
    <ul>
      <li>get (subaction)
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

<p>In addition there are two special actions, they don't have any subactions, only parameters. Thee query must have the format</p>
<code>
http://eventserver/api/&lt;responseFormat&gt;/&lt;action&gt;?param1=value1&amp;param2=value2&amp;...
</code>

<ul>
  <li>upcomingEvents
    <ul>
      <li>limit</limit>
      <li>offset</limit>
    </ul>
  </li>
  <li>filteredEvents
    <ul>
      <li>location_id (comma seperated values (csv))</li>
      <li>arranger_id (csv)</li>
      <li>category_id (csv)</li>
      <li>festival_id (csv)</li>
      <li>history (past or future)</li>
      <li>startDate (yyyy-mm-dd format)</li>
      <li>endDate (yyyy-mm-dd format)</li>
      <li>limit</li>
      <li>offset</li>
    </ul>
  </li>
</ul>

<p>These two are probably the one you'll use the most. <tt>upcomingEvents</tt> is the same as <tt>filteredEvents</tt> without any arguments-</p>

<h2 id="responseFormat">Response format</h2>

<p>
We supply two response formats: <tt>json</tt> and <tt>xml</tt>.
</p>

<p>For <tt>json</tt>, a typical response for upcoming events might look like (formatted through <a href="http://jsonlint.com">jsonlint.com</a>)</p>

<pre>
<?php echo esc_entities(file_get_contents(dirname(__FILE__) . '/apiSamples/upcomingEvents.json')) ?>
</pre>

<p>For <tt>xml</tt> it moght look like </p>

<pre>
<?php echo esc_entities(file_get_contents(dirname(__FILE__) . '/apiSamples/upcomingEvents.xml')) ?>
</pre>
