
# Loyalty Event Location Filter

Filter events by location.

## Structure

`LoyaltyEventLocationFilter`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `locationIds` | `string[]` | Required | The [location](entity:Location) IDs for loyalty events to query.<br>If multiple values are specified, the endpoint uses<br>a logical OR to combine them. | getLocationIds(): array | setLocationIds(array locationIds): void |

## Example (as JSON)

```json
{
  "location_ids": [
    "location_ids6",
    "location_ids7",
    "location_ids8"
  ]
}
```

