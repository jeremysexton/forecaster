#Forecaster

A Statamic add-on to pull in weather information from [Forecast.io](http://forecast.io).

##About

[Forecast.io](http://forecast.io) has a great API that allows you to pull in robust weather information quickly, easily, and cheaply. This plugin is my attempt to make that nice and easy in Statamic. You can grab the current weather conditions from anywhere in the world or look into the future and procure the sacred knowledge of the elements from the mystics.

Just upload the folders into the proper locations, set your API key and your defaults in the config and voila!

Say you just want your local weather on your site, you can do that. If you want the weather for events that are coming up listed with the events, you can do that. If you want to keep tabs on the ozone over your office and display that boldly on your homepage, rock on you little weirdo, you.

##Support, etc

Troll me on the tweets at [@jeremysexton](http://twitter.com/jeremysexton) or shoot me an email jeremy(at)jeremysexton.net.

If this plugin changed your life and you insist on buying me a beer, [I'm not going to stop you](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=LTC6XY9F7RTJ2).

##Example

```
{{ forecaster latitude="44.832865" longitude="-87.378731" date="2013-05-06" time="12:00:00" units="us" }}

	<p class="{{ icon }}">{{ summary }}</p>
	
	<ul>
		<li>Temp: {{ temperature }}</li>
		<li>Feels like: {{ apparentTemperature }}</li>
	</ul>

{{ /forecaster }}
```

##Documentation

###Config

*Set your defaults, yo.*

* **api_key** - Your API key, obtained from [http://developer.forecast.io](http://developer.forecast.io)
* **default_lat** - The fallback latitude when one is not passed to the plugin.
* **default_long** - The fallback longitude when one is not passed to the plugin.
* **default_units** - The default set of units to report back.
	* ***Possible values***:
		* **auto** - Units determined by location.
		* **us** - Bald eagle style.
		* **si** - SI units
		* **ca** - Same as SI, except windSpeed is reported in kilometers per hour instead of meters per second.
		* **uk** - Same as SI, except windSpeed is reported in miles per hour instead of meters per second.

###Parameters

*Passin the params, if you so choose. They're all optional.*

* **latitude** - The latitude of the location of the forecast.
* **longitude** - The longitude of the location of the forecast.
* **date** - The date of the forecast. If not set, will default to the current date. **MUST** be formatted YYYY-MM-DD.
* **time** - The time of the forecast. If not set, will default to the current time. **MUST** be formatted HH:MM:SS and is 24-hr or "military" time.
* **units** - Which units it should report in. Defaults to whatever you have set in the config.

Statamic already conveniently uses latitude and longitude to store location fields, which makes them a breeze to integrate into this. Say your location field is called "place", you could do like so:

```
{{ entries:listing folder="events" }}

	<h1>{{ title }}</h1>
	
	{{ forecaster latitude="{ place:latitude }" longitude="{ place:longitude }" date="{ date format="Y-m-d" }" time="{ time format="H:i:s }" }}
		
		<p>The weather for this event will be: {{ summary }}.</p>
		
		<ul>
			<li>Temp: {{ temperature }}</li>
			<li>Humidity: {{ humidity|*:100 }}%</li>
		</ul>
		
	{{ /forecaster }}

{{ /entries:listing }}
```

### Variables

*All the weathers. Quotes come from the [Forecast API Docs](https://developer.forecast.io/docs/v2)*

* **time** - The date/time of the forecast. Spits out in UNIX time, but can be easily reformatted with the "format=" variable modifier.
* **summary** - "A human-readable text summary of this data point." Basically, plain english for what the weather's like.
* **icon** - "A machine-readable text summary of this data point, suitable for selecting an icon for display." Gives you a little slug you can pass to CSS or an icon-font to generate a weather icon.
	* **Possible values:**
		* clear-day
		* clear-night
		* rain
		* snow
		* sleet
		* wind
		* fog
		* cloudy
		* partly-cloudy-day
		* partly-cloudy-night
	* **Potentially added later:** *(Depending on Forecast.)*
		* hail
		* thunderstorm
		* tornado
* **nearestStormDistance** - "A numerical value representing the distance to the nearest storm in miles."
* **nearestStormBearing** - "A numerical value representing the direction of the nearest storm in degrees, with true north at 0° and progressing clockwise."
* **precipIntensity** - "A numerical value representing the average expected intensity (in inches of liquid water per hour) of precipitation occurring at the given time conditional on probability (that is, assuming any precipitation occurs at all). A very rough guide is that a value of 0 in./hr. corresponds to no precipitation, 0.002 in./hr. corresponds to very light precipitation, 0.017 in./hr. corresponds to light precipitation, 0.1 in./hr. corresponds to moderate precipitation, and 0.4 in./hr. corresponds to heavy precipitation."
* **precipProbability** - "A numerical value between 0 and 1 (inclusive) representing the probability of precipitation occuring at the given time."
* **temperature** - The temperature at the given date/time.
* **apparentTemperature** - The "feels like" temperature.
* **dewPoint** - "A numerical value representing the dew point at the given time in degrees." C or F, depending on your units setting.
* **humidity** - "A numerical value between 0 and 1 (inclusive) representing the relative humidity."
* **windSpeed** - "A numerical value representing the wind speed." In the units specified depending on your settings.
* **windBearing** - "A numerical value representing the direction that the wind is coming from in degrees, with true north at 0° and progressing clockwise. (If windSpeed is zero, then this value will not be defined.)"
* **visibility** - "A numerical value representing the average visibility." In miles/kilometers. Capped at 10.
* **cloudCover** - "A numerical value between 0 and 1 (inclusive) representing the percentage of sky occluded by clouds. A value of 0 corresponds to clear sky, 0.4 to scattered clouds, 0.75 to broken cloud cover, and 1 to completely overcast skies."
* **pressure** - "A numerical value representing the sea-level air pressure." In millibars/hectopascals.
* **ozone** - "A numerical value representing the columnar density of total atmospheric ozone at the given time in Dobson units."