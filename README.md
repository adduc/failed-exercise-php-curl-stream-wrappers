## (Failed) Exercise: using stream wrappers with curl

This was a failed attempt to use stream wrappers with curl. The idea was
to use the virtual filesystem provided by mikey179/vfsstream to avoid
creating temporary files on the filesystem that risk being left behind
if the script is interrupted.

Since curl is a light wrapper around libcurl, it doesn't support PHP's
stream wrappers. This means when setting options for certificates, keys,
and other files, you have to use an actual file path.