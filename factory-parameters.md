Factory parameters:

Location:
* Proximity to resources (iron, coal, etc) increases base profitability as well as goods profitability
* Proximity to rivers (shipping) increases base profitability
* Proximity to urban centers (labor) increases base profitability

Machine/energy types:
* Steam engine, etc.
  * Worker training
  * Safety issues may change conditions
* Costs change based on years as do sold/liquedated prices

Products:
* Amount of each made depends on machinery
* Price of each is dependent on the year/market/etc

Workers:
* Wages
  - Higher wages increase worker satisfaction but decreases profit
  - Worker satisfaction increases productivity but not enough to offset base profitability decrease
    * Quadriatic representation of profability and wages?  To find "sweet spot"?
  - Worker reforms can change minimum wages/call for increases
* Quantity
  - Direct relationship with quantity of items sold

YAML-CD:
```yaml
Controller:
  Year, Date
  Speed/Freeze
  Money available
City/Region:
  Name
  Proximity to Water
  Proximity to Resources:
    Coal
    Iron
    Etc
  Population (for labor costs)
Factory:

```
