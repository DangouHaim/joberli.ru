var rootDirectory = "../olam/";
var host = "joberli.ru";
var port = 80;
var proxyHost = "joberli.ru";
var proxyPort = 80;
var res = {
	isDebug: false,
	themePath: ["./" + rootDirectory],
	fullPath: ["/wp-content/themes/" + rootDirectory],
	siteName: [host],
	sitePort: [port],
	siteProxy: [proxyHost + ":" + proxyPort]
};

module.exports = res;