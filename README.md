# ipregistry

Step:1 -- Add following class to providers  <code>Ipregistry\Laravel\IpRegistryProvider::class</code>

Step:2 -- Add alias in aliases section  <code>"Ipregistry" => Ipregistry\Laravel\GetCurrentLocation::class</code>

Step:3 -- In Controller File

<code>use Ipregistry; <br>
  Ipregistry::getcurrentlocation('Your ipregistry key here',["ip address"]);
</code>
