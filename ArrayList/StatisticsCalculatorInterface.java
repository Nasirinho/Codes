/**
 * A common task in programming is computing statistics for a set of numbers. A statistic is a numerical value that summarizes some aspect of a dataset. Some common statistics include the mean (or average) and the standard deviation, which indicates how spread out the data points are around the mean.
 * In this assignment, you will be creating a class called StatisticsCalculator.java that will performing different statistical computations.
 * To assist with this, I have created created this interface that will be implemented by your class StatisticsCalculator.java.
 * @author Steven Fulakeza
 *
 */
public interface StatisticsCalculatorInterface<I extends Number & Comparable<I>> {
	
	/**
	 * Adds the specified item to the dataset for statistical analysis.
	 * <p>
	 * This method allows an item to be added to the internal dataset, which will then
	 * be used for subsequent statistical calculations (e.g., mean, variance, etc.).
	 * The item is assumed to be of type {@link I}, and the dataset is updated accordingly.
	 * <p>
	 * Make sure that the array size is dynamic.
	 * 
	 * @param item the item to be added to the dataset
	 * @throws IllegalArgumentException if the item is invalid or cannot be added to the dataset
	 */
	public void enter(I item) throws IllegalArgumentException;
	
	/**
	 * Adds the specified item at the specified index in the dataset.
	 * <p>
	 * This method allows for inserting an item into the dataset at a given index, shifting
	 * any existing items as necessary to accommodate the new item. It provides more control 
	 * over where the item is placed within the dataset compared to adding items at the end.
	 * 
	 * @param item the item to be added to the dataset
	 * @param index the position at which the item should be inserted
	 * @throws IllegalArgumentException if the item is invalid or cannot be added to the dataset
	 * @throws IndexOutOfBoundsException if the specified index is out of the valid range
	 *         (i.e., less than 0 or greater than the current size of the dataset)
	 */
	public void enter(I item, int index)  throws IndexOutOfBoundsException, IllegalArgumentException;
	
	
	/**
	 * Adds the specified items to the dataset.
	 * <p>
	 * This method allows multiple items to be added to the dataset in a single operation. 
	 * The items provided in the array will be added to the dataset in the order they appear. 
	 * After this method is called, the dataset will include all the newly added items.
	 * 
	 * @param items an array of items to be added to the dataset
	 * @throws IllegalArgumentException if any of the items are invalid or cannot be added
	 */
	public void enterd(Object[] items) throws IllegalArgumentException;		
	
	
    /**
     * Retrieves the value at the specified index from the dataset.
     *
     * @param index the position of the element to retrieve (zero-based indexing)
     * @return the value at the specified index
     * @throws IndexOutOfBoundsException if the index is out of range (index < 0 or index >= size)
     */
    public I get(int index) throws IndexOutOfBoundsException;	
	
	
	
	
	/**
	 * Checks if the dataset is empty.
	 * <p>
	 * This method returns {@code true} if the dataset contains no items, and {@code false}
	 * if there are one or more items present in the dataset. It is useful for quickly determining
	 * whether the dataset has any data to perform operations on.
	 * 
	 * @return {@code true} if the dataset is empty, {@code false} otherwise
	 */
	public boolean isEmpty();	
	
	
	/**
	 * Returns the number of items that have been added to the dataset.
	 * <p>
	 * This method provides the current count of items stored in the dataset, which
	 * reflects the total number of items that have been entered via the {@link #enter(I)}
	 * method. It is useful for tracking the size of the dataset during statistical calculations.
	 * 
	 * @return the number of items in the dataset
	 */
	public int getCount();
	
	
	
	/**
	 * Returns the sum of all items that have been added to the dataset.
	 * <p>
	 * This method calculates and returns the sum of all items currently stored in the dataset.
	 * It is useful for performing statistical calculations such as mean or average.
	 * The result is an integer representing the total sum of the items added to the dataset.
	 * 
	 * @return the sum of all items in the dataset
	 */
	public I getSum();
	
	
	
	/**
	 * Returns the average (mean) of all items that have been added to the dataset.
	 * <p>
	 * This method calculates the mean by dividing the sum of all the items in the dataset
	 * by the total number of items. It is useful for obtaining the central tendency of the dataset.
	 * If no items have been added, the method may return a default value or throw an exception 
	 * depending on the implementation.
	 * 
	 * @return the mean (average) of all items in the dataset
	 * @throws ArithmeticException if the dataset is empty or if division by zero occurs
	 */
	public double getMean() throws ArithmeticException;
	
	
	
	/**
	 * Returns the standard deviation of all items that have been added to the dataset.
	 * <p>
	 * This method calculates the standard deviation, which measures the amount of variation
	 * or dispersion of the items in the dataset. It is computed based on the variance of the
	 * dataset, providing insight into the spread of the data. 
	 * If the dataset contains fewer than two items, the method may return a default value or
	 * throw an exception, depending on the implementation.
	 * 
	 * @return the standard deviation of the items in the dataset
	 * @throws ArithmeticException if the dataset is empty or contains only one item,
	 *         which makes the standard deviation undefined
	 */
	public double getStandardDeviation() throws ArithmeticException;
	
	
	/**
	 * Returns an array of all items that have been added to the dataset.
	 * <p>
	 * This method provides access to the raw data stored in the dataset. The items are returned
	 * as an array of {@link Object} type, allowing the caller to inspect or process the data directly.
	 * The order of the items in the returned array reflects the order in which they were added to the dataset.
	 * 
	 * @return an array containing all items in the dataset
	 */
	public Object[] getData();
	
	/**
	 * Removes the item at the specified index from the dataset and returns the removed element.
	 * <p>
	 * This method removes the item at the specified index in the dataset and returns the element 
	 * that was removed. The remaining items will be shifted to fill the gap. If the index is 
	 * out of bounds, the method will throw an {@link IndexOutOfBoundsException}.
	 * 
	 * @param index the index of the item to be removed
	 * @return the item that was removed from the dataset
	 * @throws IndexOutOfBoundsException if the specified index is out of the valid range
	 *         (i.e., less than 0 or greater than or equal to the current size of the dataset)
	 */
	public I remove(int index)  throws IndexOutOfBoundsException;
	
	/**
	 * Removes the specified item from the dataset and returns the removed element.
	 * <p>
	 * This method removes the first occurrence of the given item from the dataset, 
	 * and the item is returned. If the item exists and is successfully removed, it will 
	 * be returned; if the item is not found, the dataset remains unchanged, and the method 
	 * may return {@code null} or throw an exception depending on the implementation.
	 * 
	 * @param item the item to be removed from the dataset
	 * @return the removed item, or {@code null} if the item was not found in the dataset
	 * @throws IllegalArgumentException if the item cannot be removed or is invalid
	 */
	public I remove(I item) throws IllegalArgumentException;
	
	/**
	 * Clears all items from the dataset.
	 * <p>
	 * This method removes all items from the dataset, effectively resetting it to an empty state.
	 * After calling this method, the dataset will contain no items, and any subsequent operations
	 * will operate on an empty dataset until new items are added.
	 */
	public void clear();


	/**
	 * Returns the minimum value from the data set.
	 * 
	 * This method iterates over the stored data and determines the smallest 
	 * value in the collection. If the data set is empty, the method should 
	 * throw an IllegalArgumentException to indicate that the operation cannot 
	 * be performed on an empty data set.
	 * 
	 * @return the minimum value in the data set.
	 * @throws IllegalArgumentException if the data set is empty.
	 */
	public I getMin() throws IllegalArgumentException;
	
	
	/**
	 * Returns the maximum value from the data set.
	 * 
	 * This method iterates over the stored data and determines the largest 
	 * value in the collection. If the data set is empty, the method should 
	 * throw an IllegalArgumentException to indicate that the operation cannot 
	 * be performed on an empty data set.
	 * 
	 * @return the maximum value in the data set.
	 * @throws IllegalArgumentException if the data set is empty.
	 */
	public I getMax() throws IllegalArgumentException;
	
	/**
	 * Returns the range of the data set, which is the difference between the 
	 * maximum and minimum values.
	 * 
	 * The range is calculated by subtracting the minimum value from the maximum 
	 * value in the data set. If the data set is empty, the method should throw 
	 * an IllegalArgumentException to indicate that the operation cannot be 
	 * performed on an empty data set.
	 * 
	 * @return the range of the data set (max value - min value).
	 * @throws IllegalArgumentException if the data set is empty.
	 */
	public double getRange() throws IllegalArgumentException;
}
