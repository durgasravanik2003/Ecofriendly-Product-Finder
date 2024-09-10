import pandas as pd
import plotly.graph_objs as go
from plotly.subplots import make_subplots

# Load the existing dataset
df = pd.read_csv('eco_friendly_sales_modified.csv')

# Group data by category for pie and bar charts
category_sales = df.groupby('Category')['Sales'].sum().sort_values(ascending=False)
sustainability_counts = df['Category'].value_counts()

# Group data by date for line plots
df_grouped = df.groupby('Date').agg({'Sales': 'sum', 'Sustainability_Score': 'mean'}).reset_index()

# Create a dashboard layout using Plotly
fig = make_subplots(rows=2, cols=2, subplot_titles=(
    "Sales by Category", "Sustainability Count", "Sales Histogram", "Sustainability Score Over Time"),
    specs=[[{"type": "pie"}, {"type": "bar"}], [{"type": "histogram"}, {"type": "scatter"}]]
)

# Pie chart for sales by category
pie_trace = go.Pie(labels=category_sales.index, values=category_sales.values, name='Sales by Category')
fig.add_trace(pie_trace, row=1, col=1)

# Bar chart for sustainability count
bar_trace = go.Bar(x=sustainability_counts.index, y=sustainability_counts.values, name='Sustainability Count')
fig.add_trace(bar_trace, row=1, col=2)

# Histogram for sales distribution
histogram_trace = go.Histogram(x=df['Sales'], nbinsx=20, name='Sales Distribution')
fig.add_trace(histogram_trace, row=2, col=1)

# Line plot for sales and sustainability score over time
line_trace_sales = go.Scatter(x=df_grouped['Date'], y=df_grouped['Sales'], mode='lines', name='Sales')
line_trace_sustainability = go.Scatter(x=df_grouped['Date'], y=df_grouped['Sustainability_Score'], mode='lines', name='Sustainability Score', yaxis="y2")
fig.add_trace(line_trace_sales, row=2, col=2)
fig.add_trace(line_trace_sustainability, row=2, col=2)

# Update layout settings
fig.update_layout(
    title_text="Eco-Friendly Products Dashboard",
    showlegend=True,
    height=800,  # Adjust height for better visibility
    width=1000,  # Adjust width for better visibility
    title_x=0.5
)

# Update axis properties for subplots
fig.update_xaxes(title_text="Categories", row=1, col=1)
fig.update_yaxes(title_text="Sales", row=1, col=1)
fig.update_xaxes(title_text="Category", row=1, col=2)
fig.update_yaxes(title_text="Count", row=1, col=2)
fig.update_xaxes(title_text="Sales", row=2, col=1)
fig.update_yaxes(title_text="Frequency", row=2, col=1)
fig.update_xaxes(title_text="Date", row=2, col=2)
fig.update_yaxes(title_text="Value", row=2, col=2)
fig.update_yaxes(title_text="Sustainability Score", row=2, col=2, secondary_y=True)

# Show the dashboard
fig.show()