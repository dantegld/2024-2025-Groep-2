
# Search Events Filter

Criteria to filter events by.

## Structure

`SearchEventsFilter`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `eventTypes` | `?(string[])` | Optional | Filter events by event types. | getEventTypes(): ?array | setEventTypes(?array eventTypes): void |
| `merchantIds` | `?(string[])` | Optional | Filter events by merchant. | getMerchantIds(): ?array | setMerchantIds(?array merchantIds): void |
| `locationIds` | `?(string[])` | Optional | Filter events by location. | getLocationIds(): ?array | setLocationIds(?array locationIds): void |
| `createdAt` | [`?TimeRange`](../../doc/models/time-range.md) | Optional | Represents a generic time range. The start and end values are<br>represented in RFC 3339 format. Time ranges are customized to be<br>inclusive or exclusive based on the needs of a particular endpoint.<br>Refer to the relevant endpoint-specific documentation to determine<br>how time ranges are handled. | getCreatedAt(): ?TimeRange | setCreatedAt(?TimeRange createdAt): void |

## Example (as JSON)

```json
{
  "event_types": [
    "event_types6",
    "event_types7",
    "event_types8"
  ],
  "merchant_ids": [
    "merchant_ids5",
    "merchant_ids6",
    "merchant_ids7"
  ],
  "location_ids": [
    "location_ids8",
    "location_ids9"
  ],
  "created_at": {
    "start_at": "start_at4",
    "end_at": "end_at8"
  }
}
```

