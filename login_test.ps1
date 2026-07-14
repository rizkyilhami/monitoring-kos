$loginPage = Invoke-WebRequest -Uri 'http://127.0.0.1:8001/login' -UseBasicParsing
$token = ($loginPage.ParsedHtml.getElementsByName('_token') | Select-Object -First 1).value
$body = @{ email = 'admin@gmail.com'; password = 'admin123'; _token = $token }
$loginResponse = Invoke-WebRequest -Uri 'http://127.0.0.1:8001/login' -Method Post -Body $body -WebSession $loginPage.WebSession -UseBasicParsing -MaximumRedirection 0 -ErrorAction SilentlyContinue
Write-Output "LoginStatus=$($loginResponse.StatusCode)"
Write-Output "Location=$($loginResponse.Headers.Location)"
$dashboard = Invoke-WebRequest -Uri 'http://127.0.0.1:8001/dashboard' -WebSession $loginPage.WebSession -UseBasicParsing -ErrorAction SilentlyContinue
Write-Output "DashboardStatus=$($dashboard.StatusCode)"
Write-Output "DashboardUri=$($dashboard.BaseResponse.ResponseUri.AbsoluteUri)"
$snippet = $dashboard.Content.Substring(0, [Math]::Min(1500, $dashboard.Content.Length))
Write-Output $snippet
