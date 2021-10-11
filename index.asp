<%EnableSessionState=False
host = Request.ServerVariables("HTTP_HOST")

if host = "yu-gi-oh-buildandbuy.fr" or host = "www.yu-gi-oh-buildandbuy.fr" then response.redirect("https://www.yu-gi-oh-buildandbuy.fr/")

else
response.redirect("https://www.yu-gi-oh-buildandbuy.fr/error.htm")
end if
%>