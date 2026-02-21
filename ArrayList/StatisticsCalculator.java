import java.util.ArrayList;
import java.util.Collections;

public class StatisticsCalculator<I extends Number & Comparable<I>> implements StatisticsCalculatorInterface<I> {

    private final ArrayList<I> data;

    public StatisticsCalculator() {
        data = new ArrayList<>();
    }

    @Override
    public void enter(I item) throws IllegalArgumentException {
        if (item == null) throw new IllegalArgumentException("Item cannot be null.");
        data.add(item);
    }

    @Override
    public void enter(I item, int index) throws IndexOutOfBoundsException, IllegalArgumentException {
        if (item == null) throw new IllegalArgumentException("Item cannot be null.");
        if (index < 0 || index > data.size()) throw new IndexOutOfBoundsException("Index out of bounds.");
        data.add(index, item);
    }

    @Override
    public void enterd(Object[] items) throws IllegalArgumentException {
        if (items == null) throw new IllegalArgumentException("Items array cannot be null.");
        for (Object obj : items) {
            if (!(obj instanceof Number && obj instanceof Comparable)) {
                throw new IllegalArgumentException("All items must be Numbers and Comparable.");
            }
            @SuppressWarnings("unchecked")
            I item = (I) obj;
            data.add(item);
        }
    }

    @Override
    public I get(int index) throws IndexOutOfBoundsException {
        if (index < 0 || index >= data.size()) throw new IndexOutOfBoundsException("Index out of bounds.");
        return data.get(index);
    }

    @Override
    public boolean isEmpty() {
        return data.isEmpty();
    }

    @Override
    public int getCount() {
        return data.size();
    }

    @Override
    public I getSum() {
        double sum = 0;
        for (I item : data) {
            sum += item.doubleValue();
        }
        return castToI(sum);
    }

    @Override
    public double getMean() throws ArithmeticException {
        if (data.isEmpty()) throw new ArithmeticException("Cannot compute mean of empty dataset.");
        return getSum().doubleValue() / data.size();
    }

    @Override
    public double getStandardDeviation() throws ArithmeticException {
        if (data.size() < 2) throw new ArithmeticException("Standard deviation requires at least two items.");
        double mean = getMean();
        double sumSq = 0;
        for (I item : data) {
            double diff = item.doubleValue() - mean;
            sumSq += diff * diff;
        }
        return Math.sqrt(sumSq / data.size());
    }

    @Override
    public Object[] getData() {
        return data.toArray();
    }

    @Override
    public I remove(int index) throws IndexOutOfBoundsException {
        if (index < 0 || index >= data.size()) throw new IndexOutOfBoundsException("Index out of bounds.");
        return data.remove(index);
    }

    @Override
    public I remove(I item) throws IllegalArgumentException {
        if (item == null) throw new IllegalArgumentException("Item cannot be null.");
        boolean removed = data.remove(item);
        if (!removed) throw new IllegalArgumentException("Item not found.");
        return item;
    }

    @Override
    public void clear() {
        data.clear();
    }

    @Override
    public I getMin() throws IllegalArgumentException {
        if (data.isEmpty()) throw new IllegalArgumentException("Dataset is empty.");
        return Collections.min(data);
    }

    @Override
    public I getMax() throws IllegalArgumentException {
        if (data.isEmpty()) throw new IllegalArgumentException("Dataset is empty.");
        return Collections.max(data);
    }

    @Override
    public double getRange() throws IllegalArgumentException {
        return getMax().doubleValue() - getMin().doubleValue();
    }

  
    @SuppressWarnings("unchecked")
    private I castToI(double value) {
        if (data.isEmpty()) return null;
        Class<?> cl = data.get(0).getClass();
        if (cl == Integer.class) return (I) Integer.valueOf((int) value);
        if (cl == Long.class) return (I) Long.valueOf((long) value);
        if (cl == Float.class) return (I) Float.valueOf((float) value);
        if (cl == Double.class) return (I) Double.valueOf(value);
        throw new UnsupportedOperationException("Unsupported numeric type: " + cl.getName());
    }
}