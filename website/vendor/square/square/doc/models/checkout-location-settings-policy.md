
# Checkout Location Settings Policy

## Structure

`CheckoutLocationSettingsPolicy`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `uid` | `?string` | Optional | A unique ID to identify the policy when making changes. You must set the UID for policy updates, but it’s optional when setting new policies. | getUid(): ?string | setUid(?string uid): void |
| `title` | `?string` | Optional | The title of the policy. This is required when setting the description, though you can update it in a different request.<br>**Constraints**: *Maximum Length*: `50` | getTitle(): ?string | setTitle(?string title): void |
| `description` | `?string` | Optional | The description of the policy.<br>**Constraints**: *Maximum Length*: `4096` | getDescription(): ?string | setDescription(?string description): void |

## Example (as JSON)

```json
{
  "uid": "uid0",
  "title": "title6",
  "description": "description0"
}
```

