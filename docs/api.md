# Threat Telemetry SOC API

Base path:

```text
/api
```

## Health Check

### GET `/api/health`

Returns the current API health status.

Example response:

```json
{
  "status": "ok",
  "service": "threat-telemetry-soc"
}
```

---

## List Threat Events

### GET `/api/threat-events`

Returns paginated threat events.

Example response structure:

```json
{
  "data": [],
  "current_page": 1,
  "last_page": 1,
  "per_page": 20,
  "total": 0
}
```

---

## Get Threat Event

### GET `/api/threat-events/{id}`

Returns one threat event.

Example response:

```json
{
  "data": {
    "id": 1,
    "source_ip": "203.0.113.10",
    "destination_ip": "198.51.100.5",
    "threat_type": "Port Scan",
    "severity": "medium",
    "location": "DE",
    "payload_details": "Suspicious network activity detected.",
    "created_at": "2026-09-01T18:00:00.000000Z",
    "updated_at": "2026-09-01T18:00:00.000000Z"
  }
}
```

If the event does not exist:

```text
404 Not Found
```

---

## Create Threat Event

### POST `/api/threat-events`

Request body:

```json
{
  "source_ip": "192.168.1.10",
  "destination_ip": "10.0.0.5",
  "threat_type": "SSH Brute Force",
  "severity": "high",
  "location": "DE",
  "payload_details": "Multiple failed login attempts detected."
}
```

Successful response:

```text
201 Created
```

Validation rules:

```text
source_ip        required, valid IP
destination_ip   required, valid IP
threat_type      required, string, max 255
severity         required, low|medium|high|critical
location         optional, string, max 100
payload_details  optional, string
```

Invalid input returns:

```text
422 Unprocessable Entity
```

---

## Update Threat Event

### PATCH `/api/threat-events/{id}`

Partial updates are supported.

Example request:

```json
{
  "severity": "critical",
  "threat_type": "DDoS"
}
```

Successful response:

```json
{
  "message": "Threat event updated successfully.",
  "data": {
    "id": 1,
    "severity": "critical",
    "threat_type": "DDoS"
  }
}
```

Invalid input returns:

```text
422 Unprocessable Entity
```

Missing event returns:

```text
404 Not Found
```

---

## Response Codes

```text
200 OK
201 Created
404 Not Found
422 Unprocessable Entity
500 Internal Server Error
```